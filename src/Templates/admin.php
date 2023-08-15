<?php 
    $this->layout('template', ['title' => 'Панель администратора']); 
?>

 <div class="container">
    <div class="my_header"> 
      <header>
        <ul class="hr">
          <li><h2>Консоль администратора</h2></li>
          <li><a type="button" href="/update" class="btn btn-info">Изменить рег данные</a></li>
          <li><a type="button" href="/changepass" class="btn btn-success">Изменить пароль</a></li>
          <li><a type="button" href="/logout" class="btn btn-primary">Выход</a></li>
        </ul>
      </header>
    </div>
    <br/>
    <div class="table_container">
            <div class="btn-group">
              <input type="radio" class="btn-check" name="options" id="offer_all" autocomplete="off" checked>
              <label class="btn btn-secondary" for="offer_all">Все пользователи</label>         
              <input type="radio" class="btn-check" name="options" id="offer_select" autocomplete="off">
              <label class="btn btn-secondary" for="offer_select">Без ролей</label>
	      <button class="btn btn-outline-success" id="refresh">Обновить</button>
             
            </div>   
            <div class="scroll-table">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Никнейм</th>
                        <th scope="col">Емейл</th>
                        <th scope="col">Роль</th>
                      </tr>
                    </thead>
                  </table>	
                  <div class="scroll-table-body">
                    <table class="table">
                      <tbody id="offers">

                      </tbody>
                    </table>  
                  </div>
            </div>
      </div>
      <br/>
      <div class="d-flex flex-row">
          <div class="btn-group">
                <input type="radio" class="btn-check" name="graf" id="graf1" autocomplete="off" checked>
                <label class="btn btn-secondary" for="graf1" id="keygraf1">Текущий год</label>
              
                <input type="radio" class="btn-check" name="graf" id="graf2" autocomplete="off">
                <label class="btn btn-secondary" for="graf2" id="keygraf2">Текущий месяц</label>
              
                <input type="radio" class="btn-check" name="graf" id="graf3" autocomplete="off">
                <label class="btn btn-secondary" for="graf3" id="keygraf3">Текущий день</label>
          </div>
          &nbsp;&nbsp;&nbsp;&nbsp;<div class="grafTag">Итого за период: доход - 0, выдано ссылок - 0, переходов - 0, отказов - 0.</div>
      </div>

      <div>
        <canvas id="myChart"></canvas>
      </div>
 
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="js/script3.js"></script>