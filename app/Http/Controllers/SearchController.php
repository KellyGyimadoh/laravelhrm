<?php
namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function __invoke(Request $request)
    {
        // Use the search service to get workers
        $workers = $this->searchService->searchUsers($request);

        // Return the view with the workers data and current role
        return view('workers.index', ['workers' => $workers, 'query' => $request->input('q'), 'role' => $request->input('role', 'all')]);
    }
}
