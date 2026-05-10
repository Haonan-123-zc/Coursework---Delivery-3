<?php
require 'config.php';

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
?>
<!doctype html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='initial-scale=1, width=device-width'>
    <title>Search Result | OCS</title>
    <style>
        html { min-height: 100%; }
        body {
            overflow-x: hidden;
            min-height: 100vh;
            color: white;
            background: transparent !important;
            font-family: Tahoma, sans-serif;
            padding: 0px;
            margin: 0px;
        }
        ._nav_main_wrap {
            box-sizing: border-box;
            z-index: 9999;
            padding: 15px 40px;
            background: #111;
            align-items: center;
            justify-content: space-between;
            display: flex;
            width: 100%;
            left: 0;
            top: 0;
            position: fixed;
        }
        ._logo_a {
            align-items: center;
            display: flex;
            color: white;
            text-decoration: none;
        }
        ._icn_cx {
            font-size: 14px;
            color: black;
            background: white;
            font-weight: 700;
            align-items: center;
            justify-content: center;
            display: flex;
            border-radius: 50%;
            height: 40px;
            width: 40px;
        }
        ._txt_w {
            margin-left: 15px;
            font-weight: 700;
            font-size: 24px;
        }
        ._nav_main_wrap a.v_lk {
            margin-left: 20px;
            font-size: 16px;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }
        ._vid_back {
            z-index: -999;
            object-fit: cover;
            left: 0;
            top: 0;
            position: fixed;
            height: 100vh;
            width: 100vw;
        }
        ._ctn_plate {
            box-sizing: border-box;
            align-items: center;
            flex-direction: column;
            display: flex;
            padding: 90px 10% 60px;
            background: rgba(0,0,0,0.4);
            min-height: 100vh;
            width: 100%;
            backdrop-filter: blur(4px);
        }
        .result-wrap {
            width: 100%;
            max-width: 1100px;
            margin-top: 30px;
        }
        .car-item {
            background: rgba255,255,255,0.08;
            border: 1px solid rgba255,255,255,0.15;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
        }
        .back-btn {
            color: #1e90ff;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>

<video src='bg - Trim.mp4' muted loop autoplay playsinline class='_vid_back'></video>

<div class='_nav_main_wrap'>
    <a href=' ' class='_logo_a'>
        <div class='_icn_cx'>OCS</div>
        <div class='_txt_w'>Online Car Sale</div>
    </a >
    <div>
        <a class='v_lk' href='index.html'>Home</a >
        <a class='v_lk' href='seller.html'>Seller</a >
        <a class='v_lk' href='search.html'>Search</a >
        <a class='v_lk' href='login.html'>Login</a >
    </div>
</div>

<div class='_ctn_plate'>
    <div class="result-wrap">
        <a href="search.html" class="back-btn">← Back to Search</a >
        <h3>Search Keyword: <?php echo htmlspecialchars($keyword); ?></h3>

        <?php
        if(!empty($keyword)){
            $like = "%$keyword%";
            $sql = "SELECT brand, model, price, description FROM cars WHERE brand LIKE ? OR model LIKE ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $like, $like);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($res) > 0){
                while($row = mysqli_fetch_assoc($res)){
        ?>
            <div class="car-item">
                <h4><?php echo htmlspecialchars($row['brand'] . ' ' . $row['model']); ?></h4>
                <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p >
                <p>Description: <?php echo htmlspecialchars($row['description']); ?></p >
            </div>
        <?php
                }
            }else{
                echo "<p>No matching car found.</p >";
            }
            mysqli_stmt_close($stmt);
        }
        ?>
    </div>
</div>

</body>
</html>
<?php
mysqli_close($conn);
?>