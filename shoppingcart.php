<?php

session_start();

//testing
$_SESSION['id'] = 1;

require_once "config.php";

if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
} else die("something went wrong");

/*  
    todo:
    process update/delete
    add checkout button
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isbn = $_POST['isbn'];
    $id = $_SESSION['id'];
    $cartQuantity = $_POST['cQuantity'];
    $formQuantity = $_POST['fQuantity'];
    if (array_key_exists('del', $_POST)) {

        $del = mysqli_query($dbConnect, "DELETE from bookorder WHERE isbn = \"{$isbn}\" AND id = {$id}");
        if ($del) {
            $updateInventory = mysqli_query($dbConnect, "UPDATE book SET quantity = quantity + {$cartQuantity} WHERE isbn = \"{$isbn}\"");
            if (!$updateInventory) die("error updating inventory");
        } else die("error removing from cart");
    } else if (array_key_exists('update', $_POST)) {
        $amtRemoved = $cartQuantity - $formQuantity;
        $updateCart = mysqli_query($dbConnect, "UPDATE bookorder SET quantity = {$formQuantity} WHERE isbn = \"{$isbn}\" AND id = {$id}");
        if ($updateCart) {
            $updateInventory = mysqli_query($dbConnect, "UPDATE book SET quantity = quantity + {$amtRemoved} WHERE isbn = \"{$isbn}\"");
            if (!$updateInventory) die("error updating inventory");
        } else die("error updating cart");
    }
}

?>

<html>

<head>
    <title>Shopping Cart</title>
    <style>
        th {
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Your Cart</h1>
    <table width="40%">
        <tr>
            <th>ISBN</th>
            <th>Title</th>
            <th>Quantity</th>
            <th>Price</th>
            <th></th>

        </tr>
        <?php
        $cart = mysqli_query($dbConnect, "SELECT id, isbn, quantity FROM bookorder WHERE userID = {$userID} AND isPlaced = FALSE");
        $totalPrice = 0.00;
        while ($cartRow = mysqli_fetch_assoc($cart)) :
            $bookInfo = mysqli_query($dbConnect, "SELECT title, price, quantity FROM book WHERE isbn = \"{$cartRow['isbn']}\"");
            $bookRow = mysqli_fetch_assoc($bookInfo);
            $totalPrice += $cartRow['quantity'] * $bookRow['price'];
        ?>
            <tr>
                <td><?= $cartRow['isbn'] ?></td>
                <td><?= $bookRow['title'] ?></td>
                <td width="20%">
                    <form style="margin: 5 auto;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="updateQuantity">
                        <input type="hidden" name="isbn" value="<?= $cartRow['isbn'] ?>" />
                        <input type="hidden" name="id" value="<?= $cartRow['id'] ?>" />
                        <input type="hidden" name="cQuantity" value="<?= $cartRow['quantity'] ?>" />
                        <input name="fQuantity" value="<?= $cartRow['quantity'] ?>" style="width: 4em" type="number" step="1" max="<?= $bookRow['quantity'] + $cartRow['quantity'] ?>">
                        &nbsp;
                        <input type="submit" name="update" value="Update">
                    </form>
                </td>
                <td>$<?= $cartRow['quantity'] * $bookRow['price'] ?></td>
                <td><input type="submit" name="del" value="Remove from cart" form="updateQuantity"></td>
            </tr>
        <?php
            mysqli_free_result($bookInfo);
        endwhile;
        mysqli_free_result($cart);
        ?>
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: right;font-weight: bold;">TOTAL:&nbsp;</td>
            <td>$<?= $totalPrice ?></td>
        </tr>
    </table>
</body>

</html>