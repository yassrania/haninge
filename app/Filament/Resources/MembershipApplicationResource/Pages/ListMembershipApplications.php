<?php

// app/Filament/Resources/MembershipApplicationResource/Pages/ListMembershipApplications.php
namespace App\Filament\Resources\MembershipApplicationResource\Pages;

use App\Filament\Resources\MembershipApplicationResource;
use Filament\Resources\Pages\ListRecords;

class ListMembershipApplications extends ListRecords
{
    protected static string $resource = MembershipApplicationResource::class;
}

// app/Filament/Resources/MembershipApplicationResource/Pages/ViewMembershipApplication.php
namespace App\Filament\Resources\MembershipApplicationResource\Pages;

use App\Filament\Resources\MembershipApplicationResource;
use Filament\Resources\Pages\ViewRecord;

class ViewMembershipApplication extends ViewRecord
{
    protected static string $resource = MembershipApplicationResource::class;
}
