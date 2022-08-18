<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Data transfer object cho Student (chứa thông tin số buổi nghỉ, số phép)
class StudentDTO extends Model
{
    use HasFactory;

    protected $id;
    protected $code;
    protected $class_id;
    protected $full_name;
    protected $birthdate;
    protected $modified_by;
    protected $absentQuan;
    protected $permissionQuan;

    protected $currentStatus;
    protected $absentReason;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getClassId()
    {
        return $this->class_id;
    }

    /**
     * @param mixed $class_id
     */
    public function setClassId($class_id): void
    {
        $this->class_id = $class_id;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param mixed $full_name
     */
    public function setFullName($full_name): void
    {
        $this->full_name = $full_name;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return mixed
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }

    /**
     * @param mixed $modified_by
     */
    public function setModifiedBy($modified_by): void
    {
        $this->modified_by = $modified_by;
    }

    /**
     * @return mixed
     */
    public function getAbsentQuan()
    {
        return $this->absentQuan;
    }

    /**
     * @param mixed $absentQuan
     */
    public function setAbsentQuan($absentQuan): void
    {
        $this->absentQuan = $absentQuan;
    }

    /**
     * @return mixed
     */
    public function getPermissionQuan()
    {
        return $this->permissionQuan;
    }

    /**
     * @param mixed $permissionQuan
     */
    public function setPermissionQuan($permissionQuan): void
    {
        $this->permissionQuan = $permissionQuan;
    }

    /**
     * @return mixed
     */
    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    /**
     * @param mixed $currentStatus
     */
    public function setCurrentStatus($currentStatus): void
    {
        $this->currentStatus = $currentStatus;
    }

    /**
     * @return mixed
     */
    public function getAbsentReason()
    {
        return $this->absentReason;
    }

    /**
     * @param mixed $absentReason
     */
    public function setAbsentReason($absentReason): void
    {
        $this->absentReason = $absentReason;
    }




}
