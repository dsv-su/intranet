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
            ->allowTransition(Submitted::class, HeadApproved::class)
            ->allowTransition( HeadApproved::class, Submitted::class)
            ->allowTransition(Submitted::class, HeadReturned::class)
            ->allowTransition(HeadReturned::class, Submitted::class)
            ->allowTransition(Submitted::class, HeadDenied::class)
            ->allowTransition(HeadDenied::class, Submitted::class)

            ->allowTransition(HeadApproved::class, ViceApproved::class)
            ->allowTransition(ViceApproved::class,HeadApproved::class)
            ->allowTransition(ViceApproved::class, Submitted::class)
            ->allowTransition(HeadApproved::class, ViceReturned::class)

            ->allowTransition(ViceReturned::class,HeadApproved::class)
            ->allowTransition(ViceReturned::class,Submitted::class)
            ->allowTransition(HeadApproved::class, ViceDenied::class)
            ->allowTransition(ViceDenied::class,HeadApproved::class)
            ->allowTransition(ViceDenied::class,Submitted::class)

            ->allowTransition(ViceApproved::class, FOApproved::class)
            ->allowTransition(FOApproved::class,ViceApproved::class)
            ->allowTransition(FOApproved::class,Submitted::class)
            ->allowTransition(ViceApproved::class, FOReturned::class)


            ->allowTransition(FOReturned::class,ViceApproved::class)
            ->allowTransition(FOReturned::class,Submitted::class)
            ->allowTransition(ViceApproved::class, FODenied::class)
            ->allowTransition(FODenied::class,ViceApproved::class)
            ->allowTransition(FODenied::class,Submitted::class)
            ;
    }
}
