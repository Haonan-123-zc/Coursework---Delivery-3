<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Car Sale</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <div class="logo">OCS</div>
    <h1>Online Car Sale</h1>

    <nav>
      <a href="index.php">Home</a>
      <a href="search.php">Search Cars</a>

      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="seller.php">Sell Car</a>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="register.html">Register</a>
        <a href="login.html">Login</a>
      <?php endif; ?>
    </nav>
  </header>

  <main>
    <section>
      <h2>Find Your Ideal Car</h2>

      <p>
        Welcome to our online car sale website. We help buyers search for cars and sellers advertise their vehicles easily.
      </p>

      <?php if (isset($_SESSION['username'])): ?>
        <p>
          Welcome back, 
          <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>.
        </p>
      <?php endif; ?>

      <form action="search.php" method="GET" class="search-form">
        <input 
          type="text" 
          name="model" 
          placeholder="Enter car model"
        >

        <input 
          type="number" 
          name="year" 
          placeholder="Enter year"
          min="1900"
          max="2026"
        >

        <button type="submit">Search Cars</button>
      </form>
    </section>

    <section>
      <h2>Seller Area</h2>

      <p>
        Registered sellers can log in and advertise their cars on the website.
      </p>

      <?php if (isset($_SESSION['user_id'])): ?>
        <p>
          <a href="seller.php">Post a Car for Sale</a>
        </p>
      <?php else: ?>
        <p>
          <a href="login.html">Login</a> or 
          <a href="register.html">Register</a> to sell your car.
        </p>
      <?php endif; ?>
    </section>

    <section>
      <h2>About Our Business</h2>

      <p>
        We are a small car sale company providing a simple and convenient platform for online car trading.
      </p>
    </section>
  </main>

  <footer>
    <p>&copy; 2026 Online Car Sale</p>
  </footer>
</body>
</html>
