<nav class="navtop">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <a href="../home/home.php">
                <img src="../assets/logo.png" alt="logo" class="logo"/>
            </a>
            <div>
                <a class="navtopLink me-3 basic-link" href="../drinksList/drinksList.php"><i
                            class="me-1 fa-solid fa-wine-bottle"></i>Getränkeliste</a>
                <a class="navtopLink me-3 basic-link" href="../profile/profile.php"><i
                            class="me-1 fa-solid fa-user"></i>Profil</a>
                <a class="navtopLink basic-link" href="../common/logout.php"><i class="me-1 fas fa-sign-out-alt"></i>Logout</a>
            </div>
        </div>
    </div>
</nav>
<style>
    .navtop {
        position: sticky;
        background-color: #05212a;
        height: 60px;
        width: 100%;
        border: 0;
        margin-bottom: 15px;
    }

    .navtopLink {
        color: white;

        &:hover {
            color: white;
        }
    }

    .logo {
        height: 60px;
        width: 60px;
    }
</style>
