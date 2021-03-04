<header>
<nav class="navbar navbar-expand-lg bg-info navbar-dark">
  <a class="navbar-brand" id="navbarlogo" href="login">MyFEED</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="home">Home<span class="sr-only">(current)</span></a>
      </li>
       <li class="nav-item active">
        <a class="nav-link" href="friend">Friend</a>
      </li>
    </ul>
  




     <div id="logout-user-group" class = "logout-user-group">
      </div>
        <div class="body-icon-logout">
          <span class="navbar-text">
            <?php 
              if (isset($_COOKIE['user'])){
                echo'
                  <a id ="logout" class="icon-logout">
                    <i class="fas fa-sign-out-alt fa-2x" style="cursor:pointer"></i>
                  </a>
                ';
              }
            ?>
          </span>
      </div>
    </div>
  </div>
</nav>
    <div class = "line"></div>
    </header>