<?php

namespace App\Workflows\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

/**
 * @extends State<\App\Models\Dashboard>
 *
 */

abstract class DashboardState extends State
{
    abstract public function status(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Submitted::class)
            ->allowTransition(Submitted::class, Submitted::class)

            ->allowTransition(Submitted::class, ManagerApproved::class)
            ->allowTransition( ManagerApproved::class, Submitted::class)
            ->allowTransition(Submitted::class, ManagerReturned::class)
            ->allowTransition(ManagerReturned::class, Submitted::class)
            ->allowTransition(Submitted::class, ManagerDenied::class)
            ->allowTransition(ManagerDenied::class, Submitted::class)

            ->allowTransition(ManagerApproved::class, HeadApproved::class)
            ->allowTransition(HeadApproved::class,ManagerApproved::class)
            ->allowTransition(HeadApproved::class, Submitted::class)
            ->allowTransition(ManagerApproved::class, HeadReturned::class)
            ->allowTransition(HeadReturned::class,ManagerApproved::class)
            ->allowTransition(HeadReturned::class,Submitted::class)
            ->allowTransition(ManagerApproved::class, HeadDenied::class)
            ->allowTransition(HeadDenied::class,ManagerApproved::class)
            ->allowTransition(HeadDenied::class,Submitted::class)

            ->allowTransition(HeadApproved::class, FOApproved::class)
            ->allowTransition(FOApproved::class,HeadApproved::class)
            ->allowTransition(FOApproved::class,Submitted::class)
            ->allowTransition(HeadApproved::class, FOReturned::class)
            ->allowTransition(FOReturned::class,HeadApproved::class)
            ->allowTransition(FOReturned::class,Submitted::class)
            ->allowTransition(HeadApproved::class, FODenied::class)
            ->allowTransition(FODenied::class,HeadApproved::class)
            ->allowTransition(FODenied::class,Submitted::class)
            //PP
                //Vice
            ->allowTransition(Submitted::class, ViceApproved::class)
            ->allowTransition( ViceApproved::class, Submitted::class)
            ->allowTransition(Submitted::class, ViceReturned::class)
            ->allowTransition(ViceReturned::class, Submitted::class)
            ->allowTransition(Submitted::class, ViceDenied::class)
            ->allowTransition(ViceDenied::class, Submitted::class)
                //Complete
            ->allowTransition(ViceApproved::class, Complete::class)
            ->allowTransition(Complete::class, Submitted::class)
                //Head
            ->allowTransition(Complete::class, HeadApproved::class)
            ->allowTransition(HeadApproved::class,Complete::class)
            ->allowTransition(HeadApproved::class, Submitted::class)
            ->allowTransition(HeadApproved::class, HeadApproved::class)
            ->allowTransition(Complete::class, HeadReturned::class)
            ->allowTransition(HeadReturned::class,Complete::class)
            ->allowTransition(HeadReturned::class,Submitted::class)
            ->allowTransition(HeadReturned::class,HeadReturned::class)
            ->allowTransition(Complete::class, HeadDenied::class)
            ->allowTransition(HeadDenied::class,Complete::class)
            ->allowTransition(HeadDenied::class,Submitted::class)
            ->allowTransition(HeadDenied::class,HeadDenied::class)
                //FO
            ->allowTransition(HeadApproved::class, FOApproved::class)
            ->allowTransition(FOApproved::class,HeadApproved::class)
            ->allowTransition(FOApproved::class,Submitted::class)
            ->allowTransition(FOApproved::class,FOApproved::class)
            ->allowTransition(HeadApproved::class, FOReturned::class)

            ->allowTransition(FOReturned::class,HeadApproved::class)
            ->allowTransition(FOReturned::class,Submitted::class)
            ->allowTransition(FOReturned::class,FOReturned::class)
            ->allowTransition(HeadApproved::class, FODenied::class)
            ->allowTransition(FODenied::class,HeadApproved::class)
            ->allowTransition(FODenied::class,Submitted::class)
            ->allowTransition(FODenied::class,FODenied::class)
                //Final
            ->allowTransition(FOApproved::class, FinalApproved::class)
            ->allowTransition(FinalApproved::class,FOApproved::class)
            ->allowTransition(FinalApproved::class,Submitted::class)
            ->allowTransition(FinalApproved::class,FinalApproved::class)
            ->allowTransition(FOApproved::class, FinalReturned::class)

            ->allowTransition(FinalReturned::class,FOApproved::class)
            ->allowTransition(FinalReturned::class,Submitted::class)
            ->allowTransition(FinalReturned::class,FinalReturned::class)
            ->allowTransition(FOApproved::class, FinalDenied::class)
            ->allowTransition(FinalDenied::class,FOApproved::class)
            ->allowTransition(FinalDenied::class,Submitted::class)
            ->allowTransition(FinalDenied::class,FinalDenied::class)
            ->allowTransition(FinalApproved::class, Granted::class)
            ->allowTransition(Granted::class,FinalApproved::class)
            ->allowTransition(Granted::class,Submitted::class)
            ;
    }
}
