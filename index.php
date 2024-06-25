<?php
    include 'includes/head.php';
    include 'config.php';
?>
<title>Journal of ABC</title>
</head>

<body>
    <?php
    if(isset($_SESSION['admin_id'])){
        echo"
            <div class='admin_login_top_bar'>
                Hi $_SESSION[firstname] | 
                <a href='//$http_host/admin/dashboard'>
                    Dashboard
                </a> | 
                <a href='//$http_host/admin/includes/logout.inc'>
                    Logout
                </a>
            </div>
        ";
    } 
?>
    <?php
    include 'includes/navbar.php';
    ?>

    <section class='p-3'>
        <div class="container">
            <div class="row mt-5">
                <div class="col-sm-6">
                    <h3 class='color-brown'><b>Journal of Politics</b></h3>
                    <p class='text-justify mt-3'>
                        Journal of Politics is a peer-reviewed research journal of the Department of Political Science.
                        Dibrugarh University. It is an annual journal that publishes articles/research papers/book
                        reviews
                        on
                        all aspects of politics and allied subjects. The journal intends to provide a suitable forum for
                        publication and dissemination of original research works that contribute to the understanding of
                        the
                        discipline of Political Science and its emerging trends.
                    </p>
                </div>
                <div class="col-sm-6 text-center">
                    <img src="assets/img/cover.png" alt="" class='hero-image'>
                </div>
            </div>
        </div>
        <br> <br> <br>
    </section>
    <section class='p-3' style='background-color: #FAFAFA'>
        <div class=" container">
            <div class="row">
                <h3 class='color-brown text-center my-3'><b>Latest Issues</b></h3>
            </div>
            <div class="row mt-3">
                <?php
                    $sql = "SELECT * FROM journals ORDER BY journal_id DESC LIMIT 4";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){   
                        echo "Error";
                    } else {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if($result->num_rows > 0 ){
                            while($row = mysqli_fetch_assoc($result)){
                                echo "
                                    <div class='col-sm-3 mt-3'>
                                        <div class='card py-3'>
                                            <div class='card-body'>
                                                <div class='title'>
                                                    <center>
                                                        <h5><b>$row[title]</b></h5>
                                                    </center>
                                                </div>
                                                <center>$row[published_date]</center> <br>
                                                <center>
                                                    <a href='articles?journal_id=$row[journal_id]'><button class='issue-card-btn'>Read</button></a>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                ";
                            }
                        }
                    }
                ?>
            </div>
        </div> <br> <br> <br>
    </section>
    <section class='p-3' style='background-color: #985A48'>
        <div class="container py-5">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class='color-white'><b>Publisher</b></h4>
                    <h5 class='color-white'>Registrar</h5>
                    <p class='color-white'>
                        Dibrugarh University <br>
                        Assam-786004 <br>
                        E-mail: registrar@dibru.ac.in <br>
                        Phone: 0373 2370231
                    </p>
                </div>
                <div class="col-sm-6">
                    <h4 class='color-white'><b>Chief Editor</b></h4>
                    <h5 class='color-white'>Dr. Obja Borah Hazarika</h5>
                    <p class='color-white'>
                        <i>Assistant Professor</i> <br>
                        Department of Political Science <br>
                        Dibrugarh University <br>
                        Assam-786004 <br>
                        E-mail: obja@dibru.ac.in <br>
                        Phone: 8486878112 <br>
                        Profile link: <a href="" class='anchor1'>https://dibru.ac.in/userlist/welcome/profile/236</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class='p-3' style='background-color: #FAFAFA'>
        <div class="container">
            <div class="row">
                <h3 class='color-brown text-center my-3'><b>Editorial Board</b></h3>
            </div>
            <div class="row mt-3">
                <div class="col-sm-4 mt-3">
                    <div class="card py-3">
                        <div class="card-body">
                            <div class="title">
                                <center>
                                    <h6><b>Prof. ABC</b></h6>
                                </center>
                            </div>
                            <p>
                                <i>Professor</i> <br>
                                Department of XYZ <br>
                                Dibrugarh University <br>
                                Assam-786004 <br>
                                E-mail: example@dibru.ac.in <br>
                                Phone: 8956321450 <br>
                                Profile link: <a href=""
                                    class='anchor1'>https://dibru.ac.in/userlist/welcome/profile/231</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mt-3">
                    <div class="card py-3">
                        <div class="card-body">
                            <div class="title">
                                <center>
                                    <h6><b>Prof. ABC</b></h6>
                                </center>
                            </div>
                            <p>
                                <i>Professor</i> <br>
                                Department of XYZ <br>
                                Dibrugarh University <br>
                                Assam-786004 <br>
                                E-mail: example@dibru.ac.in <br>
                                Phone: 8956321450 <br>
                                Profile link: <a href=""
                                    class='anchor1'>https://dibru.ac.in/userlist/welcome/profile/231</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mt-3">
                    <div class="card py-3">
                        <div class="card-body">
                            <div class="title">
                                <center>
                                    <h6><b>Prof. ABC</b></h6>
                                </center>
                            </div>
                            <p>
                                <i>Professor</i> <br>
                                Department of XYZ <br>
                                Dibrugarh University <br>
                                Assam-786004 <br>
                                E-mail: example@dibru.ac.in <br>
                                Phone: 8956321450 <br>
                                Profile link: <a href=""
                                    class='anchor1'>https://dibru.ac.in/userlist/welcome/profile/231</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br> <br> <br>
    </section>
    <section class='p-3' style='background-color: #985A48'>
        <div class="container">
            <div class="row">
                <h3 class='color-white text-center my-3'><b>Contact Us</b></h3>
            </div>
            <div class="row mt-3">
                <div class="col-sm-6 mt-3">
                    <ul class='contact-list'>
                        <li>
                            <div class="list">
                                <i class="fa-solid fa-envelope"></i>
                                <span>example@example.com</span>
                            </div>
                        </li>
                        <li>
                            <div class="list">
                                <i class="fa-solid fa-phone"></i>
                                <span>+91 12345 67890</span>
                            </div>
                        </li>
                        <li>
                            <div class="list">
                                <i class="fa-solid fa-house"></i>
                                <span>
                                    Department of ABC <br>
                                    Dibrugarh Univesity, Dibrugarh-786004
                                </span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 mt-3">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3540.634749140504!2d94.8952813752442!3d27.449491576331308!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3740a2daaaaaaaab%3A0x3c0d978a22c76583!2sDibrugarh%20University!5e0!3m2!1sen!2sin!4v1718713471291!5m2!1sen!2sin"
                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        <br> <br> <br>
    </section>

    <?php
    include 'includes/footer.php';
?>
</body>

</html>