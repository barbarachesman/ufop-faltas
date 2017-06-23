<!-- Modals -->

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">LOGIN</h4>
         </div>
         <form class="form-horizontal" method="POST" action="{{url('login')}}">
            {{ csrf_field() }}
            <div class="modal-body">

               <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input class="form-control input-xlarge" type="text" maxlength="14" name="username" id="username" placeholder="CPF (somente números)" autofocus required oninvalid="setCustomValidity('Informe o usuário.')" oninput="setCustomValidity('')"
                  >
                     {{-- <p class="help-block">{{"Apenas números"}}</p> --}}
               </div>
               <br/>
               <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input class="form-control input-xlarge " type="password"
                     name="password" id="password" placeholder="Senha" required
                     oninvalid="setCustomValidity('Informe a senha.')"
                     oninput="setCustomValidity('')"
                  >
               </div>

            </div>

            <div class="modal-footer">
               <button type="submit" class="btn modal-btn btn-primary-ufop">Entrar</button>
               <button type="reset" class="btn modal-btn btn-default">Limpar</button>
            </div>
         </form>
      </div>
   </div>
</div>
