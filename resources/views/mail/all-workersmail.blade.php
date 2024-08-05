

<x-layout theTitle="Send Mail To Workers" href="/mails/worker">
    <div class="row">
             <div class="col-xl-8">
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->

                    <!-- Profile Edit Form -->
                    <x-forms.form method="POST" action='/mails/workers/{{Auth::user()->id}}' enctype="multipart/form-data"
                        novalidate>
                        <x-forms.input label="Sender" name="sender" value="{{Auth::user()->email}}"/>
                        <x-forms.field label="Recipient" name="">

                            <x-forms.select name="recipient">
                                <option value="">Select Recipient</option>
                                <option value="all">All Workers</option>
                                <option value="admin">All Admins</option>
                                <option value="staff">All Staffs</option>
                                @foreach ($workers as $worker )

                                    <option value="{{$worker->email}}">{{$worker->firstname.' '.$worker->lastname}}</option>
                                @endforeach
                            </x-forms.select>
                        </x-forms.field>
                        <x-forms.input name="subject" label="Subject" placeholder="Subject" />
                        <x-forms.field label="Message" name="">
                            <textarea cols="50" rows="4" name="body"></textarea>

                        </x-forms.field>

                        <x-forms.button class="w-100">Send Mail</x-forms.button>
                    </x-forms.form><!-- End Profile Edit Form -->


                </div>
            </div>
        </div>
    </div>
</x-layout>

<!-- End Bordered Tabs -->
