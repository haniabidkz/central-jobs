<?php
namespace App\Repository;
use App\Http\Model\User;

class UserRepository {

    /**
     * Create user model
     * @param array $data
     * @return User
     */
    public function create(array $data) {

        $user = User::create($data);
        return $user;
    }

    /**
     * Update user model
     * @param array $data
     * @return User
     */
    public function update(array $data, array $condition) {
        User::where($condition)
            ->update($data);
    }

    /**
     * Find a particular user details
     * @param array $condition
     * @return User
     */
    public function find($condition){
        $user = User::where($condition)->first();
        return $user;        
    }

    /**
     * Find count of user with condition
     * @param array $condition
     * @return userCount
     */
    public function findCount($condition){
        $userCount = User::where($condition)->count();
        return $userCount;        
    }

    public function verifyUserEmail($email){
        $user = User::where('email', '=', $email['email'])->first();
        return $user;
    }

    public function verifyAdminEmail($email){
        $user = User::where([['email',$email['email']],['id',1]])->first();
        return $user;
    }

}