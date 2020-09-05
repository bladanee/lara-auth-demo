<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CompanyController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Companies = Company::with(['addedByAdmin'])->paginate(config('vars.Pagination'));
        return view('company.home')->with(['Companies' => $Companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['email', 'max:255', 'unique:companies,email'],
            'website' => ['max:255'],
            'logo' =>   ['dimensions:min_width=100,min_height=100']
        ]);
        $logoFileName = null;
        if($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoFileName = time() . '.' . $logo->getClientOriginalExtension();
            Storage::disk('public')->put('Company/'.$logoFileName,  File::get($logo));
        }
        Company::create([
            'name'          =>   $request->post('name'),
            'email'         =>   $request->post('email'),
            'website'       =>   $request->post('website'),
            'logo'          =>   $logoFileName,
            'added_by'      =>   $this->AuthAdmin->user()->id ?? null,
        ]);
        return redirect()->back()->withSuccess("Company created successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Company = Company::find($id);
        return view('company.edit')->with(['Company' => $Company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['email', 'max:255', 'unique:companies,email,'.$id],
            'website' => ['max:255'],
            'logo' =>   ['dimensions:min_width=100,min_height=100']
        ]);

        $Company            = Company::find($id);
        $logoFileName       = $Company->logo;
        if($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoFileName = time() . '.' . $logo->getClientOriginalExtension();
            Storage::disk('public')->put('Company/'.$logoFileName,  File::get($logo));
        }
        
        $Company->name      =  $request->post('name');
        $Company->email     =  $request->post('email');
        $Company->website   =  $request->post('website');
        $Company->logo      =  $logoFileName;
        $Company->save();

        return redirect()->back()->withSuccess("Company updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Company = Company::destroy($id);
        return redirect()->back()->withSuccess("Company deleted successfully!");
    }
}
