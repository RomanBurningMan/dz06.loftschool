<?php
/**
 * Created by PhpStorm.
 * User: пользователь
 * Date: 26.11.2017
 * Time: 15:56
 */

namespace App;

use PDOException;

class dbQuery
{
    private $host = 'localhost';
    private $db_name = 'test1';
    private $user = 'mysql';
    private $pass = 'password';

    public $name;
    public $email;
    public $phone;
    public $street;
    public $house;
    public $house_block;
    public $apt;
    public $floor;
    public $comment;
    public $need_cashback;
    public $need_callback;

    public function __construct()
    {
        $this->name          = htmlspecialchars($_POST["name"]);
        $this->email         = htmlspecialchars($_POST["email"]);
        $this->phone         = htmlspecialchars($_POST["phone"]);
        $this->street        = htmlspecialchars($_POST["street"]);
        $this->house         = htmlspecialchars($_POST["home"]);
        $this->house_block   = htmlspecialchars($_POST["part"]);
        $this->apt           = htmlspecialchars($_POST["appt"]);
        $this->floor         = htmlspecialchars($_POST["floor"]);
        $this->comment       = htmlspecialchars($_POST["comment"]);
        $this->need_cashback = htmlspecialchars($_POST["payment"]);
        $this->need_callback = htmlspecialchars($_POST["callback"]);
    }
    public function query()
    {
        try {
            $DBH = new \PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->user, $this->pass);
            $DBH->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            $prepareQuery = $DBH->prepare("SELECT id, user_email FROM users_login WHERE user_email = :email");
            $prepareQuery->bindParam(':email', $this->email);
            if ($prepareQuery->execute()) {
                $result = $prepareQuery->fetchAll();
                $customer_data = array(
                    'phone'         => $this->phone,
                    'street'        => $this->street,
                    'house'         => $this->house,
                    'house_block'   => $this->house_block,
                    'apt'           => $this->apt,
                    'floor'         => $this->floor,
                    'comment'       => $this->comment,
                    'need_cashback' => $this->need_cashback,
                    'need_callback' => $this->need_callback
                );
                $user_id = NULL;
                if (empty($result)) {
                    $data = array(
                        'user_name'  => $this->name,
                        'user_email' => $this->email
                    );
                    $userRegister = $DBH->prepare("INSERT INTO users_login (user_name, user_email)
                VALUE (:user_name, :user_email)");
                    $userRegister->execute($data);
                    $user_id = $DBH->lastInsertId();
                } else {
                    $user_id = $result[0]['id'];
                }
                $addCustomerInfo = $DBH->prepare("INSERT INTO customer_data (user_id, tel, street,
            house, house_block, apt, floor, comments, need_cashback, need_callback) VALUE (
            $user_id, :phone, :street, :house, :house_block, :apt, :floor, :comment, :need_cashback, :need_callback)");
                if ($addCustomerInfo->execute($customer_data)) {
                    $getOrderQuantity = $DBH->query("SELECT COUNT(user_id) AS quantity 
                FROM customer_data 
                WHERE user_id=$user_id;")->fetchAll();
                    $quantityOrders = $getOrderQuantity[0]['quantity'];
                    $title = 'Заказ бургера.';
                    if ($quantityOrders == 1) {
                        $orderInMessage = "Спасибо, это ваш первый заказ!";
                    } else {
                        $orderInMessage = "Спасибо! Это уже $quantityOrders заказ.";
                    }
                    $message = "Ваш заказ будет доставлен по адресу: ул.".$this->street.",".
                        $this->house_block.",".$this->apt."Заказ: DarkBeefBurger за 500 рублей, 1 шт. ".$orderInMessage;
                    $message = wordwrap($message, 70, "\r\n");
                    // Prepare data for sending message
                    $mailer = new Mailer($this->email,$this->name,$title,$message,$message);
                    $mailer->sendMail();
                    return array('email'=>$this->email,'name'=>$this->name);
                };
            }
        } catch (PDOException $e) {
            file_put_contents(__DIR__.'/../log/PDOErrors.txt',date("Y-m-d H-i ").$e->getMessage()."\r\n",FILE_APPEND);
        }
    }
}