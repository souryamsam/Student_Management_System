<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    public function login_checked($phon_no, $password)
    {
        $data = [
            'phone_number' => $phon_no,
            'password' => $password
        ];
        $query = $this->db->table('tbl_login_info')->where($data)->get();
        if ($query->getNumRows() > 0) {
            return $query->getRowArray();
        } else {
            return false;
        }
    }
    public function show_all_data()
    {
        $builder = $this->db->table('tbl_user u');
        $builder->select('u.id, u.name, u.contact_p, u.number, u.email, u.gender, c.c_name AS country_name, s.s_name AS state_name, d.d_name AS district_name, u.p_address, u.c_address, u.status');
        $builder->join('country c', 'u.country = c.c_id');
        $builder->join('state s', 'u.state = s.s_id');
        $builder->join('district d', 'u.city = d.d_id');
        $builder->where('u.status', 'ACTIVE');
        $query = $builder->get();
        $data = $query->getResultArray();
        return $data;
    }
    public function pageload_data()
    {
        $query = $this->db->table('country')->get();
        return $query->getResultArray();
    }
    public function fetch_state_data($postdata)
    {
        $country_id = $postdata['country'];
        $query = $this->db->table('state')->where('c_id', $country_id)->get();
        $data = $query->getResultArray();
        return $data;
    }
    public function fetch_city_data($postdata)
    {
        $state_id = $postdata['state_code'];
        $query = $this->db->table('district')->where('s_id', $state_id)->get();
        $data = $query->getResultArray();
        return $data;
    }
    public function duplicate_checking_phoneNumber($postdata)
    {
        $value = $postdata['c_number'];
        $query = $this->db->table('tbl_user')->where('number', $value)->get();
        if ($query->getNumRows() > 0) {
            return [
                'status' => 1,
                'message' => 'Duplicate.'
            ];
        } else {
            return [
                'status' => 0,
                'message' => 'Something went wrong!'
            ];
        }
    }
    public function duplicate_checking_Email($postdata)
    {
        $value = $postdata['email'];
        $query = $this->db->table('tbl_user')->where('email', $value)->get();
        if ($query->getNumRows() > 0) {
            return [
                'status' => 1,
                'message' => 'Duplicate.'
            ];
        } else {
            return [
                'status' => 0,
                'message' => 'Something went wrong!'
            ];
        }
    }
    public function insert_add_user($postdata)
    {
        $id = $postdata['user_id'];
        $data = [
            'name' => $postdata['name'],
            'contact_p' => $postdata['c_person'],
            'number' => $postdata['c_number'],
            'email' => $postdata['email'],
            'gender' => $postdata['gender'],
            'country' => $postdata['country'],
            'state' => $postdata['state'],
            'city' => $postdata['city'],
            'p_address' => $postdata['p_address'],
            'c_address' => $postdata['c_address'],
        ];
        if ($id) {
            $query = $this->db->table('tbl_user')->update($data, ['id' => $id]);

            if ($query) {
                return [
                    'status' => 1,
                    'message' => 'User successfully updated.'
                ];
            } else {
                return [
                    'status' => 0,
                    'message' => 'Something went wrong while updating!'
                ];
            }
        } else {
            $duplicate_number = $this->duplicate_checking_phoneNumber($postdata);
            $duplicate_email = $this->duplicate_checking_Email($postdata);
            if ($duplicate_number['status'] == 1) {
                return [
                    'status' => 0,
                    'message' => 'Duplicate phone number found.'
                ];
            } elseif ($duplicate_email['status'] == 1) {
                return [
                    'status' => 0,
                    'message' => 'Duplicate Email ID found.'
                ];
            } else {
                $query = $this->db->table('tbl_user')->insert($data);

                if ($query) {
                    return [
                        'status' => 1,
                        'message' => 'User successfully added.'
                    ];
                } else {
                    return [
                        'status' => 0,
                        'message' => 'Something went wrong while inserting!'
                    ];
                }
            }
        }
    }

    public function update_status($postdata)
    {
        $user_id = $postdata['custom_id'];
        $query = $this->db->table('tbl_user')->where('id', $user_id)->update(['status' => 'INACTIVE']);
        if ($query) {
            return [
                'status' => 1,
                'message' => 'User deleted successfully.'
            ];
        } else {
            return [
                'status' => 0,
                'message' => 'Something went wrong!'
            ];
        }
    }
    public function get_user_data($user_id)
    {
        $query = $this->db->table('tbl_user')->where('id', $user_id)->get();
        $data = $query->getResultArray();
        return $data;
    }
    public function insert_photo($postData, $filePath)
    {
        $data = [
            'name' => $postData['name'],
            'address' => $postData['address'],
            'document' => $filePath
        ];
        $query = $this->db->table('document')->insert($data);

        if ($query) {
            return [
                'status' => 1,
                'message' => 'User successfully added.'
            ];
        } else {
            return [
                'status' => 0,
                'message' => 'Something went wrong while inserting!'
            ];
        }
    }
    protected $table = '';
    protected $primaryKey = '';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
}