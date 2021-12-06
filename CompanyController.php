<?php

namespace App\Http\Controllers\Panel;

use App\Http\Requests\Panel\CompanyStoreRequest;
use App\Http\Requests\Panel\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\CompanyCategory;
use Illuminate\Http\Request;

// use App\Models\Permission;

class CompanyController extends Controller
{

    public function index(Request $request)
    {
        // $this->authorize('list', Post::class);
        // $this->authorize('view', $post);

        $companies = Company::where(function ($q) use ($request) {
            if ($request->filled('filter.name')) {
                $q->where('name', 'like', $request->input('filter.name') . '%');
            }

            if ($request->filled('filter.category_id')) {
                $q->where('category_id', $request->input('filter.category_id'));
            }
        })
            ->with('category.translations')
            ->withCount('branches')
            ->orderBy('name', 'asc')
            ->paginate(20);

        $categories = CompanyCategory::all();

        $total_companies = Company::where(function ($q) use ($request) {
            if ($request->filled('filter.name')) {
                $q->where('name', 'like', $request->input('filter.name') . '%');
            }

            if ($request->filled('filter.category_id')) {
                $q->where('category_id', $request->input('filter.category_id'));
            }
        })->count();

        return view('panel.companies.index')->with(compact('companies', 'categories', 'total_companies'));
    }

    public function create()
    {
        // $this->authorize('create', $company);

        $categories = CompanyCategory::all();

        return view('panel.companies.create')->with(compact('categories'));
    }

    public function store(CompanyStoreRequest $request)
    {
        // $this->authorize('store', $company);

        $validated = $request->validated();

        $company = Company::create($validated);

        return redirect()->route('panel.companies.index')->withSuccess(__('Company created successfully.'));
    }

    public function edit(Company $company)
    {
        // $this->authorize('edit', $company);

        $categories = CompanyCategory::all();

        return view('panel.companies.edit')->with(compact('company', 'categories'));
    }

    public function update(CompanyUpdateRequest $request, Company $company)
    {
        // $this->authorize('update', $company);

        $validated = $request->validated();

        $company->update($validated);

        return back()->withSuccess(__('Company updated successfully.'));
    }

    public function destroy(Company $company)
    {
        // $this->authorize('delete', $company);

        $company->delete();

        return back()->withSuccess(__('Company deleted successfully.'));
    }
}
