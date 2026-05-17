<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\User;

class CompanyController extends Controller
{
    protected $moduleName;

    public function __construct()
    {
        //Module Name
        $this->moduleName = 'Company';
        view()->share('moduleName', $this->moduleName);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the search parameter from the request
        $company = request()->input('company');

        // Start building the query
        $query = Company::with('meta');

        // Filter by company_id if authenticated user has one, otherwise, return all companies
        if (auth()->user()->company_id) {
            $query->where('id', auth()->user()->company_id);
        }

        // If company term is provided, apply the company condition
        if ($company) {
            $query->where('id', $company);
        }

        // Execute the query and get the results
        $pageData = $query->get();

        // Get dropdown data
        $companyList = getCompanyList();
        return view('backend.companies.index', compact('pageData', 'companyList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $query = Company::with('meta');

        if (auth()->user()->company_id) {
            $query->where('id', auth()->user()->company_id);
        }

        $pageData = $query->findOrFail($id);

        return view('backend.companies.edit', compact('pageData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {     
            $company = Company::findOrFail($id);
        
            // Update main company fields
            $company->name = $request->input('name');
            $company->logo = $request->input('logo');
            $company->email = $request->input('email');
            $company->phone = $request->input('phone');
            $company->address = $request->input('address');
            $company->website = $request->input('website');
            $company->google_map = $request->input('google_map');
            $company->meta_title = $request->input('meta_title');
            $company->meta_description = $request->input('meta_description');
            $company->save();
        
            // Handle meta fields
            $metaFields = $request->input('meta', []); // Get all meta fields from the request

            foreach ($metaFields as $key => $value) {
                // Check if the meta key exists for the current company
                $existingMeta = $company->meta()->where('meta_key', $key)->first();
        
                if ($existingMeta) {
                    // If the meta key exists, update it regardless of $value being empty
                    $existingMeta->update(['meta_value' => $value]);
                } else {
                    // If the meta key does not exist, create a new record only if $value is not empty
                    if (!empty($value)) {
                        $company->meta()->create([
                            'meta_key' => $key,
                            'meta_value' => $value
                        ]);
                    }
                }
            }            

            return redirect()->route('companies.edit', $company->id)->with('success', 'Company details updated successfully!');

        } catch (\Exception $e) {
            // Log the error message with a detailed stack trace
            Log::error('Error updating company details for company ID ' . $id, [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
    
            // Optionally, return a failure message to the user
            return redirect()->route('companies.edit', $id)->with('error', 'There was an error updating the company details.');
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Show change password form for company user.
     */
    public function showChangePasswordForm($id)
    {
        $pageData = Company::findOrFail($id);
        return view('backend.companies.change-password', compact('pageData'));
    }

    /**
     * Change password for company user.
     */
    public function changePassword(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        
        // Get user by company_id
        $user = User::where('id', 1)->first();
        
        if (!$user) {
            return response()->json(['status' => false, 'notification' => 'No user found for this company.']);
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ], [
            'password.min' => 'Password must be at least 8 characters long.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*#?&).',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'notification' => $validator->errors()->first()]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['status' => true, 'notification' => 'Password changed successfully!']);
    }
}