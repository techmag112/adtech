<?php 
    $this->layout('template', ['title' => 'Консоль заказчика']); 
?>

<div class="container">
    <div class="my_header"> 
      <header>
        <ul class="hr">
          <li><h1>Консоль заказчика</h1></li>
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
              <label class="btn btn-secondary" for="offer_all">Все офферы</label>         
              <input type="radio" class="btn-check" name="options" id="offer_select" autocomplete="off">
              <label class="btn btn-secondary" for="offer_select">Только активные</label>
              <button class="btn btn-outline-success" id="new">Новый</button>
             
            </div>   
            <div class="scroll-table">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Название</th>
                        <th scope="col">Стоимость</th>
                        <th scope="col">URL</th>
                        <th scope="col">Ключевые слова</th>
                        <th scope="col">Число подписок</th>
                      </tr>
                    </thead>
                  </table>	
                  <div class="scroll-table-body">
                    <table class="table">
                      <tbody id="offers">
                        <!-- сюда вставляется таблица -->
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
          &nbsp;&nbsp;&nbsp;&nbsp;<div class="grafTag">Итого за период: переходы - 0, потрачено - 0.</div>
      </div>

      <div>
        <canvas id="myChart"></canvas>
      </div>
 
      <div class="layerAddOffer">
        <form>
          <div class="mb-3">
            <label for="nameOffer" class="form-label">Название</label>
            <input type="text" class="form-control" id="nameOffer" aria-describedby="nameOffer" required />
            <div id="nameHelp" class="form-text">Введите короткое название оффера</div>
          </div>
          <div class="mb-3">
            <label for="sumOffer" class="form-label">Стоимость перехода</label>
            <input type="text" pattern="(^[0-9]{0,4}$)|(^[0-9]{0,4}\.[0-9]{0,2}$)"
                    maxlength="7" validate="true"
                    class="form-control" id="sumOffer" required />
            <div id="sumHelp" class="form-text">Введите стоимость в формате "2.53"</div>
          </div>
          <div class="mb-3">
            <label for="urlOffer" class="form-label">URL</label>
            <input type="text" pattern="(^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$)"
                   validate="true" class="form-control" id="urlOffer" required />
            <div id="urlHelp" class="form-text">Введите url оффера без http/https</div>
          </div>
          <div class="mb-3">
            <label for="keyOffer" class="form-label">Ключевые слова</label>
            <input type="text" class="form-control" id="keyOffer" aria-describedby="keyOffer" required />
            <div id="keyHelp" class="form-text">Введите ключевые слова через пробел</div>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="reset" class="btn btn-primary" id="reset">Отмена</button>
            <button type="submit" class="btn btn-primary" id="addoffer">Добавить</button>
          </div>
        </form>
      </div>
  </div>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="js/script.js"></script>