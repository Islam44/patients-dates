<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Gate;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function allowedAdminAction()
    {
        if (Gate::denies('admin-action')) {
            throw new AuthorizationException('This action is unauthorized-this action for admins only');
        }
    }
    protected function allowedDoctorAction()
    {
        if (Gate::denies('doctor-action')) {
            throw new AuthorizationException('This action is unauthorized-this action for doctors only');
        }
    }
    protected function allowedPatientAction()
    {
        if (Gate::denies('user-action')) {
            throw new AuthorizationException('This action is unauthorized-this action for patients only');
        }
    }
}
