<?php

/**
 * Laravel Models PHPDoc annotations for IDE support
 * This file provides property and method documentation for Laravel models
 */

namespace App\Models {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Database\Eloquent\Builder;

    /**
     * @property int $AgencyID
     * @property string $AgencyName
     * @property string $AgencyEmail
     * @property string $AgencyUserName
     * @property string $AgencyPassword
     * @property string $AgencyPhoneNum
     * @property string $AgencyDescription
     * @property \Carbon\Carbon $created_at
     * @property \Carbon\Carbon $updated_at
     * 
     * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
     * @method static Builder with($relations)
     * @method static Builder orderBy($column, $direction = 'asc')
     * @method static Builder orderByDesc($column)
     * @method static Collection|Agency[] get($columns = ['*'])
     * @method static Agency|null first($columns = ['*'])
     * @method static Agency|null find($id, $columns = ['*'])
     * @method static Agency findOrFail($id, $columns = ['*'])
     * @method static Agency create(array $attributes = [])
     * @method static int count($columns = '*')
     * @method bool save(array $options = [])
     * @method bool update(array $attributes = [], array $options = [])
     */
    class Agency extends Model {}

    /**
     * @property int $InquiryID
     * @property int $UserID
     * @property int $AgencyID
     * @property int $AdminID
     * @property string $InquiryTitle
     * @property string $InquiryDescription
     * @property string $InquiryStatus
     * @property string $InquiryPriority
     * @property \Carbon\Carbon $InquirySendDate
     * @property string $AttachmentPath
     * @property \Carbon\Carbon $created_at
     * @property \Carbon\Carbon $updated_at
     * 
     * @property-read Agency $agency
     * @property-read PublicUser $user
     * @property-read Admin $admin
     * 
     * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
     * @method static Builder with($relations)
     * @method static Builder orderBy($column, $direction = 'asc')
     * @method static Builder orderByDesc($column)
     * @method static Collection|Inquiry[] get($columns = ['*'])
     * @method static Inquiry|null first($columns = ['*'])
     * @method static Inquiry|null find($id, $columns = ['*'])
     * @method static Inquiry findOrFail($id, $columns = ['*'])
     * @method static Inquiry create(array $attributes = [])
     * @method static int count($columns = '*')
     * @method bool save(array $options = [])
     * @method bool update(array $attributes = [], array $options = [])
     */
    class Inquiry extends Model {}

    /**
     * @property int $UserID
     * @property string $UserName
     * @property string $UserEmail
     * @property string $UserPassword
     * @property string $UserPhoneNum
     * @property string $UserProfilePicture
     * @property \Carbon\Carbon $created_at
     * @property \Carbon\Carbon $updated_at
     * 
     * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
     * @method static Builder with($relations)
     * @method static Builder orderBy($column, $direction = 'asc')
     * @method static Builder orderByDesc($column)
     * @method static Collection|PublicUser[] get($columns = ['*'])
     * @method static PublicUser|null first($columns = ['*'])
     * @method static PublicUser|null find($id, $columns = ['*'])
     * @method static PublicUser findOrFail($id, $columns = ['*'])
     * @method static PublicUser create(array $attributes = [])
     * @method static int count($columns = '*')
     * @method bool save(array $options = [])
     * @method bool update(array $attributes = [], array $options = [])
     */
    class PublicUser extends Model {}

    /**
     * @property int $AdminID
     * @property string $AdminName
     * @property string $AdminEmail
     * @property string $AdminPassword
     * @property \Carbon\Carbon $created_at
     * @property \Carbon\Carbon $updated_at
     * 
     * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
     * @method static Builder with($relations)
     * @method static Builder orderBy($column, $direction = 'asc')
     * @method static Builder orderByDesc($column)
     * @method static Collection|Admin[] get($columns = ['*'])
     * @method static Admin|null first($columns = ['*'])
     * @method static Admin|null find($id, $columns = ['*'])
     * @method static Admin findOrFail($id, $columns = ['*'])
     * @method static Admin create(array $attributes = [])
     * @method static int count($columns = '*')
     * @method bool save(array $options = [])
     * @method bool update(array $attributes = [], array $options = [])
     */
    class Admin extends Model {}
}
