<!-- Topbar -->

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">



    <!-- Sidebar Toggle (Topbar) -->

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">

        <i class="fa fa-bars"></i>

    </button>



    <!-- Topbar Navbar -->

    <!-- <div class="logo">
    </div> -->
    <div class="logo">
        <svg width="88" height="24" viewBox="0 0 320 88" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M59.4439 85.5176H0V2.81299H59.5553V22.1743H20.9674V34.3732H56.6556V53.6228H20.9674V66.1563H59.4439V85.5176Z" fill="black"></path>
        <path d="M127.269 47.6906V2.81299H147.789V85.5176H132.065L94.5921 41.2003V85.5176H74.1816V2.81299H89.126L127.269 47.6906Z" fill="black"></path>
        <path d="M191.107 86.9707C177.351 86.9707 166.161 82.1978 157.537 72.6459L168.02 57.3136C174.936 64.2532 182.742 67.7219 191.441 67.7219C194.043 67.7219 196.236 67.1819 198.022 66.099C199.807 65.019 200.698 63.5441 200.698 61.6787C200.698 59.0679 198.467 56.942 194.007 55.2994L186.645 52.8375C181.366 50.8981 177.872 49.4798 176.162 48.5849C167.09 43.7357 162.555 36.5733 162.555 27.0976C162.555 19.7864 165.417 13.7062 171.143 8.85552C176.868 4.00707 184.228 1.58133 193.225 1.58133C204.451 1.58133 214.23 5.05077 222.557 11.9889L212.854 27.8808C210.401 25.8666 207.352 24.2256 203.71 22.9561C200.065 21.6888 196.683 21.0544 193.56 21.0544C190.809 21.0544 188.653 21.5582 187.092 22.5649C185.53 23.5723 184.75 24.8592 184.75 26.4262C184.75 28.8142 186.942 30.8654 191.33 32.5805L198.579 35.2675C202.594 36.6858 205.753 37.8798 208.058 38.8479C218.542 43.3248 223.785 50.5628 223.785 60.5587C223.785 68.1697 220.81 74.5128 214.862 79.5855C208.988 84.5095 201.069 86.9707 191.107 86.9707Z" fill="black"></path>
        <path d="M293.935 55.7557C293.934 55.7564 293.933 55.7572 293.933 55.7587C293.934 55.7572 293.935 55.7564 293.936 55.7549C293.936 55.7557 293.935 55.7557 293.935 55.7557ZM276.672 -3.28494e-06C269.803 -3.28494e-06 263.306 1.59349 257.522 4.42628C260.212 3.72167 263.925 2.81316 266.832 2.81316C285.223 2.81316 300.187 17.8283 300.187 36.2833C300.187 42.7011 298.374 48.7005 295.24 53.7997C295.21 53.8495 295.177 53.8963 295.148 53.9462C294.762 54.5594 294.358 55.1621 293.936 55.7542C291.021 59.6201 285.89 62.946 281.005 63.9988C279.613 64.3009 278.16 64.4648 276.672 64.4648C265.338 64.4648 256.154 55.2489 256.154 43.8755C256.154 32.502 265.338 23.2862 276.672 23.2862C286.63 23.2862 294.92 30.3965 296.795 39.8366C296.889 38.8442 296.941 37.8353 296.941 36.8165C296.941 22.2946 287.024 10.0987 273.616 6.67077C256.393 2.26789 239.514 16.4281 234.329 32.3577C228.613 49.9186 235.557 69.3404 251.843 80.7055C267.288 91.4824 289.736 90.0958 304.036 78.0155C317.7 66.4721 323.101 47.5065 318.252 30.6676C315.48 21.0432 308.63 12.3273 300.285 6.94265C293.268 2.41592 285.012 -3.28494e-06 276.672 -3.28494e-06Z" fill="black"></path>
        </svg>
    </div>
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - User Information -->

        <!-- <li class="nav-item no-arrow">

            <a class="nav-link text-dark" href="<?php echo $admin_url; ?>admin" aria-expanded="false">

                Home

            </a>

        </li> -->



        <div class="topbar-divider d-none d-sm-block"></div>



        <li class="nav-item dropdown no-arrow">

            

            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['nj_admin']; ?></span>

                <img class="img-profile rounded-circle" src="<?php echo $admin_url; ?>assets/admin/user.png">

            </a>

            <!-- Dropdown - User Information -->

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">



                <div class="dropdown-divider"></div>

                <!-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"> -->

                <a class="dropdown-item" href="<?php echo $admin_url; ?>logout.php" >

                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>

                    Logout

                </a>

            </div>

        </li>



    </ul>



</nav>

<!-- End of Topbar -->