<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function profileImage()
    {
        $image = asset('images/avatar.png');

        if ($this->photo) {
            $image = asset('storage/user/' . $this->photo);
        }

        return $image;
    }


    public function toggleStatus()
    {
        if ($this->status) {
            $this->status = False;
        } else {
            $this->status = True;
        }

        $this->save();
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function userBranches(): HasMany
    {
        return $this->hasMany(UserBranches::class, 'user_id', 'id');
    }

    public function userProjects(): HasMany
    {
        return $this->hasMany(user_projects::class, 'user_id', 'id');
    }

    public function usersUnit(): HasMany
    {
        return $this->hasMany(UserUnit::class, 'user_id', 'id');
    }


    public function userProjectIds()
    {
        $project = Project::where('company_id', Auth::user()->company_id);

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {

            $projectIds = Auth::user()->userProjects->pluck('project_id')->toArray();
            $branchIds = Auth::user()->userBranches->pluck('branch_id')->toArray();

            if ($projectIds) {
                $project = $project->whereIn('id', $projectIds);
            } else {
                $project = $project->whereIn('branch_id', $branchIds);
            }
        }

        return $project->select('id')->get()->pluck('id')->toArray();
    }

    public function userProject()
    {
        $projects = Project::where('company_id', Auth::user()->company_id);

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $projectIds = Auth::user()->userProjects->pluck('project_id')->toArray();
            $projects = $projects->whereIn('id', $projectIds);
        }

        return $projects = $projects->get();
    }

    public function userUnits()
    {
        $units = Unit::where('company_id', Auth::user()->company_id);

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $units = $units->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return $units->get();
    }


    public static function userDatatable()
    {
        $users = User::with(['userBranches', 'userProjects']);

        if (!Auth::user()->hasRole(['Software Admin'])) {
            $users = $users->where('company_id', Auth::user()->company_id)->where('id', '!=', Auth::user()->id);
        }

        return DataTables::eloquent($users)
            ->addIndexColumn()
            ->addColumn('company_name', function ($row) {
                $company = Company::find($row->company_id);
                return $company?->name;
            })
            ->addColumn('branch_name', function ($row) {
                $branches = Branch::whereIn('id', $row->userBranches->pluck('branch_id')->toArray())->get();
                $branchTxt = '';

                foreach ($branches as $branch) {
                    $branchTxt .= $branch->name . ',';
                }

                return $branchTxt;
            })
            ->addColumn('project_name', function ($row) {

                $projects = Project::whereIn('id', $row->userProjects->pluck('project_id')->toArray())->get();
                $projectTxt = '';

                foreach ($projects as $project) {
                    $projectTxt .= $project->project_name . ',';
                }

                return $projectTxt;
            })
            ->addColumn('roles', function ($row) {
                $roles = User::findOrFail($row->id)->roles()->get()->pluck(['name'])->toArray();
                $roles_string = implode(",", $roles);
                return $roles_string;
            })
            ->addColumn('status_ui', function ($row) {
                $status = $row->status;
                $checked = "";

                if ($status) {
                    $checked = "checked";
                }

                $slide_button = '<div class="toggle">
                  <label>
                    <input onclick="toggleStatus(' . $row->id . ')" type="checkbox" ' . $checked . '><span class="button-indecator"></span>
                  </label>
                </div>';

                if (Auth::user()->can('status user')) {
                    return $slide_button;
                }
                return "";
            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('edit user')) {
                    $btn = $btn . '<a href="' . route('user.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                }

                if (Auth::user()->can('change_password user')) {
                    $btn = $btn . '<a href="' . route('changepassword.view', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i> Change Password</a>';
                }

                if (Auth::user()->can('delete user')) {
                    $btn = $btn . "<a href='#' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-pencil' aria-hidden='true'></i> Delete</a>";
                }

                $btn = $btn . '
                </div>
                </div>';

                return $btn;
            })
            // ->order(function ($row) {
            //     $row->orderBy('name', 'desc');
            // })
            ->rawColumns(['status_ui', 'action'])
            ->toJson();
    }
}
