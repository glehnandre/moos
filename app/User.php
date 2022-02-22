<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes, EntrustUserTrait {
        SoftDeletes::restore insteadof EntrustUserTrait;
        EntrustUserTrait::restore insteadof SoftDeletes;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'telefone', 'password', 'cpf'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPassword($token, $this->nome));
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }


    public function eventos()
    {
        return $this->belongsToMany('App\Evento', 'evento_usuarios');
    }

    public function rolesIds(){
        $rolesId = array();
        foreach( $this->roles as $role ){
            array_push($rolesId,$role->id);
        }
        return $rolesId;
    }

    public function isAdministrator()
   {    
        foreach( $this->roles as $role )
        {
            if( $role->name == 'admin') return true;
        }
        return false;
   } 

   public function isAdministratorOuGestor()
   {    
        foreach( $this->roles as $role )
        {
            if( $role->name == 'admin' || $role->name == 'gestor') return 1;
        }
        return 0;
   } 


}
