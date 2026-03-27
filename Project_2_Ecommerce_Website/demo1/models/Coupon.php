<?php
class Coupon {
    private $pdo;
    public function __construct() { global $pdo; $this->pdo = $pdo; }

    public function validateCoupon($code) {
        $stmt = $this->pdo->prepare("SELECT * FROM coupons WHERE code = ? AND expiry_date > NOW() LIMIT 1");
        $stmt->execute([$code]);
        return $stmt->fetch();
    }
}
?>
