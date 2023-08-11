<?php 
    use function Tamtamchik\SimpleFlash\flash;
    use Tm\Adtech\Core\Token;
    use Tm\Adtech\Core\Input;
    use Tm\Adtech\Core\Session;

    if(isset($message)) {
        flash()->message($message, $type);
    } else {
        if (Session::exists('message')) {
            flash()->message(Session::get('message'), Session::get('type'));
            Session::delete('message');
            Session::delete('type');
        }
    }
    $this->layout('template', ['title' => 'Регистрация']); 
?>

<section>
    <div class="d-flex flex-column min-vh-100 justify-content-center">
    <div class="container">
        <div class="row" >
            <div class="col-sm-12 col-md-10 mx-auto bg-white rounded shadow">
                <div class="row">
                    <div class="col-md-6">
                        <div class="m-5 text-center"><h2>SF-AdTech</h2></div>
            
                            <?php echo flash()->displayBootstrap(); ?> 

                            <form  action="" method="post" class="m-5">
                            <div class="mb-3">
                                <label class="form-label" for="username">Никнейм</label>
                                <input type="text" name="username" class="form-control" value="<?php echo Input::get('username')?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">E-mail</label>
                                <input type="text" name="email" class="form-control" value="<?php echo Input::get('email')?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Пароль</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Пароль еще раз</label>
                                <input type="password" name="password_again" class="form-control">
                            </div>
                            <div class="row mb-3">
                                <input type="hidden" name="token" class="form-control" value="<?php echo Token::generate(); ?>"> 
                            </div>
                            <div class="">
                                <input
                                type="submit"
                                class="form-control btn btn-primary mt-3"
                                />
                            </div>
                            </form>
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
