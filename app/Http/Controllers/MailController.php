<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Mail\CustomWorkerMail;


use App\Models\User;
use App\Models\WorkersMail ;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    protected $searchService;
    public function __construct(SearchService $searchService){
        $this->searchService=$searchService;
    }
    public function index(){
        $mails=WorkersMail::with('user')->latest()->paginate(5);
        return view('mails.index',['mails'=>$mails]);
    }
    public function create()
    {
        $user = Auth::user();
        return view('mail.workers-mail', ['worker' => $user]);
    }

    public function search(Request $request){
        $query = $request->input('q', 'all');
        $searchDate = $request->input('searchdate','all');
        $mailquery = WorkersMail::query();

        if ($searchDate !== 'all') {
            $mailquery->where('created_at', $searchDate);
        }

        if ($query && $query !== 'all') {
           $mailquery->where('recipient','LIKE','%'.$query.'%');
        }

        $mails = $mailquery->latest()->paginate(6)->appends(['q' => $query, 'searchdate' => $searchDate]);

        return view('mails.index', ['mails' => $mails, 'query' => $query, 'searchdate' => $searchDate]);

    }
    public function sent()
    {

        return view('mail.custom');
    }

    public function edit($id)
    {
        $mail=WorkersMail::findOrFail($id);
        $user=Auth::user();
        return view('mails.edit',['mail'=>$mail,'worker' => $user]);
    }
    public function allWorkers()
    {
        $workers = User::all();
        return view('mail.all-workersmail', ['workers' => $workers]);
    }
    public function store(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'recipient' => ['email', 'required'],
            'body' => ['required'],
            'subject' => ['required']

        ]);

      $email=  WorkersMail::create(array_merge($validatedData, ['user_id' => $user->id]));
       /* Mail::send(new CustomWorkerMail(
            $validatedData['subject'],
            $validatedData['body'],

            $validatedData['recipient'],
            $user->email
        ));

        //using jobs
        dispatch(new SendMailJob(
            $validatedData['subject'],
            $validatedData['body'],
            $validatedData['recipient'],
            $user->email
        ));
        */
        dispatch(new SendMailJob($email));
        return redirect('/mails/sent')->with([
            'success' => 'Mail sent Successfully', 'subject' => $validatedData['subject'],
            'body' => $validatedData['body']
        ]);
    }

    public function update(Request $request,User $user){
        $validatedData= $request->validate([
            'sender'=>['required'],
            'body'=>['required'],
            'recipient'=>['required'],
            'subject'=>['required']
        ]);

        $email= WorkersMail::updateOrCreate(array_merge($validatedData,['user_id'=>$user->id]));

        dispatch(new SendMailJob($email));
        return redirect('/mail/'.$email->id)->with('success','Mail Resent successfully');
    }
    public function storeAll(Request $request,User $user)
    {

        $validatedData = $request->validate([
            'recipient' => ['required'],
            'body' => ['required'],
            'subject' => ['required'],
        ]);

        $workerTypes = $validatedData['recipient'];
        $recipients = [];

        if ($workerTypes == 'all') {
            $recipients = User::all('email');
        } elseif ($workerTypes == 'staff') {
            $recipients = User::where('role', 'staff')->pluck('email');
        } elseif ($workerTypes == 'admin') {
            $recipients = User::where('role', 'admin')->pluck('email');
        } else {
            $recipients = collect([$workerTypes]);
        }

        foreach ($recipients as $recipient) {
          $email=  WorkersMail::create([
                'recipient' => $recipient->email,
                'body' => $validatedData['body'],
                'subject' => $validatedData['subject'],
                'user_id' => $user->id,
            ]);

           /* Mail::send(new CustomWorkerMail(
                $validatedData['subject'],
                $validatedData['body'],
                $recipient->email,
                $user->email
            ));
              //using jobs
        dispatch(new SendMailJob(
            $validatedData['subject'],
            $validatedData['body'],
            $recipient->email,
            $user->email
        ));
        */
        dispatch(new SendMailJob($email));
        }

        return redirect('/mails/sent')->with('success', 'Mail sent Successfully');
    }

    public function delete($id){
        $mail=WorkersMail::findOrFail($id);
        $mail->delete();
        return redirect('/mails')->with('success','Mail successfully removed');
    }
}
