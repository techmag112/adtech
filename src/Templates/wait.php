<?php 
    $this->layout('template', ['title' => 'Ожидает выбор роли']); 
?>

<section>
      <header>
          <ul class="nav justify-content-end hr">
            <li><a type="button" href="/logout" class="btn btn-primary">Выход</a></li>
          </ul>
      </header>
    <br/>
    <div class="d-flex flex-column min-vh-100 justify-content-center">
        <div class="container">
            <div class="row" >
                <div class="col-sm-12 col-md-10 mx-auto bg-white rounded shadow">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="m-5 text-center"><h3>SF-AdTech</h3></div>
                                <h3>Ожидайте назначение роли администратором!</h3>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <img src="./img/signup.svg" alt="login" class="img-fluid p-5" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>