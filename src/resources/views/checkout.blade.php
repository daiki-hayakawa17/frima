<!DOCTYPE html>
<html>
  <head>
    <title>Buy cool new product</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://js.stripe.com/v3/"></script>
  </head>
  <body>
    <section>
      <div class="product">
        <img src="{{ asset($item->image) }}" alt="The cover of Stubborn Attachments" />
        <div class="description">
          <h3>{{ $item->name }}</h3>
          <h5>{{ $item->price }}</h5>
        </div>
      </div>
      <form action="/checkout.php" method="POST">
        <button type="submit" id="checkout-button">Checkout</button>
      </form>
    </section>
  </body>
</html>