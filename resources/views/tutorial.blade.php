@extends('layout.base')

@section('titulo')
    Tutorial
@endsection

@section('descricao')
    Este tutorial fornece o passo a passo para a utilização do Diário.
    É relevante que você o leia e veja as instruções para que possa rapidamente familiarizar-se com a forma de manipulação dos recursos disponíveis.
@endsection

@section('conteudo')


<ul class="timeline">
          <!-- timeline time label -->
          <li class="time-label">
                <span class="bg-gray">
                  Acesso Professor - Recursos permitidos somente para docentes
                </span>
          </li>
          <li>
            <i class="fa fa-plus bg-green"></i>

            <div class="timeline-item">

              <h3 class="timeline-header"><a href="#">Criar Turma</a> Minhas Turmas > Criar Turma</h3>

              <div class="timeline-body">
                A partir da fase de ajuste de matrícula, os professores tem acesso ao diário das turmas que ministrarão. Portanto, com o diário de classe de extensão (.csv), o professor escolherá o arquivo no seu dispositivo e importará para a plataforma através do botão Importar.
                Assim, a turma estará criada e pronta para o gerenciamento de faltas.
              </div>
            </div>
          </li>
          <li>
            <i class="fa fa-th-list bg-yellow"></i>
            <div class="timeline-item">
              <h3 class="timeline-header no-border"><a href="#">Listar Turmas</a> Minhas Turmas > Listar Turmas</h3>
              <div class="timeline-body">
                Cadastrada as turmas, o professor visualizará todas as turmas as quais ele é responsável.
                Podendo obter detalhes de cada uma delas ou visualizar o diário.
              </div>
            </div>
          </li>
          <li>
            <i class="fa fa-group bg-red"></i>

            <div class="timeline-item">

              <h3 class="timeline-header"><a href="#">Gerenciar Turmas</a> Minhas Turmas > Listar Turmas > Detalhes </h3>

              <div class="timeline-body">
                Take me to your leader!
                Switzerland is small and neutral!
                We are more like Germany, ambitious and misunderstood!
              </div>
            </div>
          </li>

          <li>
            <i class="fa fa-hand-paper-o bg-blue"></i>

            <div class="timeline-item">

              <h3 class="timeline-header"><a href="#">Gerenciar Faltas</a> Minhas Turmas > Listar Turmas > Visualizar Diário > Gerenciar Faltas</h3>

              <div class="timeline-body">
                Take me to your leader!
                Switzerland is small and neutral!
                We are more like Germany, ambitious and misunderstood!
              </div>
            </div>
          </li>

          <li>
            <i class="fa fa-calendar  bg-yellow"></i>

            <div class="timeline-item">

              <h3 class="timeline-header"><a href="#">Visualizar Diário</a> Minhas Turmas > Listar Turmas > Visualizar Diário</h3>

              <div class="timeline-body">
                Take me to your leader!
                Switzerland is small and neutral!
                We are more like Germany, ambitious and misunderstood!
              </div>
            </div>
          </li>
          <li class="time-label">
                <span class="bg-gray">
                  Acesso Aluno - Recursos permitidos para discentes
                </span>
          </li>
          <li>
            <i class="fa fa-th-list bg-blue"></i>

            <div class="timeline-item">

              <h3 class="timeline-header"><a href="#">Listar Turmas</a> uploaded new photos</h3>

              <div class="timeline-body">
                <img src="http://placehold.it/150x100" alt="..." class="margin">
                <img src="http://placehold.it/150x100" alt="..." class="margin">
              </div>
            </div>
          </li>
          <li>
            <i class="fa fa-calendar bg-maroon"></i>

            <div class="timeline-item">

              <h3 class="timeline-header"><a href="#">Visualizar Faltas</a> shared a video</h3>

              <div class="timeline-body">
                aijoidjas
              </div>
            </div>
          </li>
          <li class="time-label">
                <span class="bg-gray">
                  Acesso Aluno - Recursos permitidos para discentes
                </span>
          </li>
          <li>
            <i class="fa fa-th-list bg-blue"></i>

            <div class="timeline-item">

              <h3 class="timeline-header"><a href="#">Video explicativo</a> uploaded new photos</h3>
              <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tMWkeBIohBs" frameborder="0" allowfullscreen></iframe>
              </div>
            </div>
          </li>
        </ul>


        Como é um sistema pioneiro no controle de faltas, assim como todo processo novo, ele certamente estará
        em constante ajuste até sua consolidação final, requerendo, portanto, muita PACIÊNCIA de todos os
        envolvidos, docentes e alunos.
        Manteremos todos informados à medida que novas ações forem necessárias.
        As dúvidas e sugestões devem ser direcionadas por e-mail a chesman12@gmail.com.

        Este tutorial é mantido por Bárbara Chesman.
@endsection
