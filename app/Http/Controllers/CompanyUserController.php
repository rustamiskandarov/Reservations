<?php

namespace App\Http\Controllers;

use App\Http\Enums\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseIsSuccessful;

class CompanyUserController extends Controller
{
    public function index(Company $company): View
    {
        $this->authorize('viewAny', $company);

        $users = $company->users()->get();
        return view('companies.users.index', compact('users', 'company'));
    }

    public function create(Company $company): View
    {
        $this->authorize('create', $company);

        return view('companies.users.create', compact('company'));
    }

    public function store(Company $company, StoreUserRequest $request)
    {
        $this->authorize('create', $company);

        $company->users()->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role_id' => Role::COMPANY_OWNER->value,
        ]);
        return to_route('companies.users.index', $company);
    }

    public function edit(Company $company, User $user)
    {
        $this->authorize('update', $company);

        return view('companies.users.edit', compact('company', 'user'));
    }

    public function update(UpdateUserRequest $request, Company $company, User $user)
    {
        $this->authorize('update', $company);

        $user->update($request->validated());
        return to_route('companies.users.index', $company);
    }

    public function destroy(Company $company, User $user)
    {
        $this->authorize('delete', $company);

        $user->delete();
        return to_route('companies.users.index', $company);
    }
}
