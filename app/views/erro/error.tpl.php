<section class="error" style="min-height:500px; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMC8yOS8xMiKqq3kAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAABHklEQVRIib2Vyw6EIAxFW5idr///Qx9sfG3pLEyJ3tAwi5EmBqRo7vHawiEEERHS6x7MTMxMVv6+z3tPMUYSkfTM/R0fEaG2bbMv+Gc4nZzn+dN4HAcREa3r+hi3bcuu68jLskhVIlW073tWaYlQ9+F9IpqmSfq+fwskhdO/AwmUTJXrOuaRQNeRkOd5lq7rXmS5InmERKoER/QMvUAPlZDHcZRhGN4CSeGY+aHMqgcks5RrHv/eeh455x5KrMq2yHQdibDO6ncG/KZWL7M8xDyS1/MIO0NJqdULLS81X6/X6aR0nqBSJcPeZnlZrzN477NKURn2Nus8sjzmEII0TfMiyxUuxphVWjpJkbx0btUnshRihVv70Bv8ItXq6Asoi/ZiCbU6YgAAAABJRU5ErkJggg==);">  
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="error-template" style="padding:6rem 1rem 3rem;text-align:center;">
          <h2><?=(!empty($data['title']) ? $data['title'] : '404 Not Found')?></h2>
          <div class="error-details alert alert-danger">
            <?=(!empty($data['msg']) ? $data['msg'] : 'Desculpe, houve um erro, a pagina solicitada não existe!')?>
          </div>
          <div class="error-actions" style="margin-top:15px;margin-bottom:15px;">
            <a href="/" class="btn btn-primary btn-lg" style="margin-right:10px;"><span class="fa fa-home"></span>
              Pagina Inicial </a><a href="http://www.jquery2dotnet.com" class="btn btn-success btn-lg"><span class="fa fa-envelope"></span> Contatar Suporte </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>