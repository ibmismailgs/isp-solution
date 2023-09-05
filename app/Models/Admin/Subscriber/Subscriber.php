<?php

namespace App\Models\Admin\Subscriber;

use Spatie\Permission\Models\Role;
use App\Models\Admin\Settings\Area;
use App\Models\Admin\Settings\Device;
use App\Models\Admin\Settings\Package;
use App\Models\Admin\Settings\Identity;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Settings\ConnectionType;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Subscriber\SubscriberCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class Subscriber extends Model implements ToModel, WithHeadingRow
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'subscribers';

    public function idcards(): BelongsTo
    {
        return $this->belongsTo(Identity::class, 'card_type_id', 'id')->withTrashed();
    }
    public function areas(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id', 'id')->withTrashed();
    }
    public function categories(): BelongsTo
    {
        return $this->belongsTo(SubscriberCategory::class, 'category_id', 'id')->withTrashed();
    }
    public function connections(): BelongsTo
    {
        return $this->belongsTo(ConnectionType::class, 'connection_id', 'id')->withTrashed();
    }
    public function packages(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id', 'id')->withTrashed();
    }
    public function devices(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id', 'id')->withTrashed();
    }

    public function roles(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role', 'id');
    }

    public function model(array $row)
    {
        $cardTypesRow = $row['card_type'];
        $cardNoRow = $row['card_no'];
        $cardTypes = explode (",", $cardTypesRow);
        $cardNos = explode (",", $cardNoRow);

        $cardTypeIds= [];
        foreach($cardTypes as $value){

            $cardType= Identity::where('name', $value )->first();

            $cardTypeIds[]= $cardType->id;
        }

        $initialize_date = intval($row['initialize_date']);
        $birth_date = intval($row['birth_date']);



        return new Subscriber([
           'subscriber_id' => $row['subscriber_id'],
           'name' => $row['name'],
           'initialize_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($initialize_date)->format('d/m/Y'),
           'birth_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($birth_date)->format('d/m/Y'),
           'card_type_id' => json_encode($cardTypeIds),
           'card_no' => json_encode($cardNos),
           'area_id' => Area::where('name', $row['area_name'])->firstOrFail()->id,
           'address' => $row['address'],
           'contact_no' => $row['contact_no'],
           'category_id' => SubscriberCategory::where('name', $row['client_category'])->firstOrFail()->id,
           'connection_id' => ConnectionType::where('name', $row['connection_type'])->firstOrFail()->id,
           'package_id' => Package::where('name', $row['package_type'])->firstOrFail()->id,
           'device_id' => Device::where('name', $row['device'])->firstOrFail()->id,
           'ip_address' => $row['ip_address'],
           'email' => $row['email'],
           'password' => Hash::make($row['password']),
           'status' => $row['status']=='Active' ? 1 : 0,
           'description' => $row['description'],
        ]);
    }
}
