<?php

namespace App\Workflows\States\Project;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

/**
 * @extends State<\App\Models\Dashboard>
 *
 */

abstract class StatesConfig extends State
{
    abstract public function status(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Submitted::class)
            ->allowTransition(Submitted::class, Submitted::class)
            //Vice
            ->allowTransition(Submitted::class, ViceApproved::class)
            ->allowTransition( ViceApproved::class, Submitted::class)
            ->allowTransition(Submitted::class, ViceReturned::class)
            ->allowTransition(ViceReturned::class, Submitted::class)
            ->allowTransition(Submitted::class, ViceDenied::class)
            ->allowTransition(ViceDenied::class, Submitted::class)
            //Head
            ->allowTransition(ViceApproved::class, HeadApproved::class)
            ->allowTransition(HeadApproved::class,ViceApproved::class)
            ->allowTransition(HeadApproved::class, Submitted::class)
            ->allowTransition(ViceApproved::class, HeadReturned::class)
            ->allowTransition(HeadReturned::class,ViceApproved::class)
            ->allowTransition(HeadReturned::class,Submitted::class)
            ->allowTransition(ViceApproved::class, HeadDenied::class)
            ->allowTransition(HeadDenied::class,ViceApproved::class)
            ->allowTransition(HeadDenied::class,Submitted::class)
            //FO
            ->allowTransition(HeadApproved::class, FOApproved::class)
            ->allowTransition(FOApproved::class,HeadApproved::class)
            ->allowTransition(FOApproved::class,Submitted::class)
            ->allowTransition(HeadApproved::class, FOReturned::class)
            ->allowTransition(FOReturned::class,HeadApproved::class)
            ->allowTransition(FOReturned::class,Submitted::class)
            ->allowTransition(HeadApproved::class, FODenied::class)
            ->allowTransition(FODenied::class,HeadApproved::class)
            ->allowTransition(FODenied::class,Submitted::class)

            ;
    }
}
