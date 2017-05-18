<?php $__env->startSection('titulo'); ?>
    Tutorial
<?php $__env->stopSection(); ?>

<?php $__env->startSection('descricao'); ?>
    Este tutorial fornece o passo a passo para a utilização do Diário.
    É relevante que você o leia e veja as instruções para que possa rapidamente familiarizar-se com a forma de manipulação dos recursos disponíveis.
<?php $__env->stopSection(); ?>

<?php $__env->startSection('conteudo'); ?>


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
                Podendo obter detalhes dos dados de cada uma delas ou visualizar o diário.
              </div>
            </div>
          </li>
          <li>
            <i class="fa fa-group bg-red"></i>

            <div class="timeline-item">

              <h3 class="timeline-header"><a href="#">Gerenciar Turmas</a> Minhas Turmas > Listar Turmas > Detalhes </h3>

              <div class="timeline-body">
                O gerenciamento das turmas será feito a partir da seleção de determinada turma,
                assim será apresentado os alunos matrículados e seus respectivos dados, permitindo que o professor desmatricule um aluno ou
                finalize a turma, caso as aulas do período se encerrem. Nesta tela será possivel carregar um diário atualizado após diferentes ajustes
                de matrícula, e assim automaticamente alunos serão adicionados ou excluídos de determinada turma.
              </div>
            </div>
          </li>

          <li>
            <i class="fa fa-hand-paper-o bg-blue"></i>

            <div class="timeline-item">

              <h3 class="timeline-header"><a href="#">Gerenciar Faltas</a> Minhas Turmas > Listar Turmas > Visualizar Diário > Gerenciar Faltas</h3>

              <div class="timeline-body">
                O gerenciamento de faltas conta com o registro das faltas, podendo cadastrar faltas em um período de tempo ao mesmo tempo,
                ou cadastrando somente uma chamada. Por exemplo, registrar faltas de uma semana inteira, ou somente de uma aula.
              </div>
            </div>
          </li>

          <li>
            <i class="fa fa-calendar  bg-yellow"></i>

            <div class="timeline-item">

              <h3 class="timeline-header"><a href="#">Visualizar Diário</a> Minhas Turmas > Listar Turmas > Visualizar Diário</h3>

              <div class="timeline-body">
              Na apresentação do diário, o professor o acessa conforme a turma escolhida. De modo que liste o diário de todos as aulas
              em que a chamada foi realizada. Em que cada linha representa a presença ou falta do aluno em determinado dia.
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

              <h3 class="timeline-header"><a href="#">Listar Turmas</a> Minhas Turmas > Listar Turmas</h3>

              Nesta página são listadas todas as turmas que o aluno logado está matriculado. A partir da criação das turmas, automaticamente
              o aluno é vínculado a turma e assim o aluno só precisa listar as turmas e consultar suas faltas.
            </div>
          </li>
          <li>
            <i class="fa fa-calendar bg-maroon"></i>

            <div class="timeline-item">

              <h3 class="timeline-header"><a href="#">Visualizar Faltas</a> shared a video</h3>

              <div class="timeline-body">
                Para cada turma em que o aluno está matrículado é possível visuallizar as faltas registradas para ele.
              </div>
            </div>
          </li>
          <li class="time-label">
                <span class="bg-gray">
                  Vídeo de apresentação da plataforma - Diário de Classe
                </span>
          </li>
          <li>
            <div class="timeline-item">
                <img src="http://i.picasion.com/pic85/02cb79bee0bc42c0ab69203256ae8ab0.gif" alt="..." class="margin">
            </div>
          </li>
        </ul>


        Como é um sistema pioneiro no controle de faltas, assim como todo processo novo, ele certamente estará
        em constante ajuste até sua consolidação final, requerendo, portanto, muita PACIÊNCIA de todos os
        envolvidos, docentes e alunos.
        Manteremos todos informados à medida que novas ações forem necessárias.
        As dúvidas e sugestões devem ser direcionadas por e-mail a chesman12@gmail.com.

        Este tutorial é mantido por Bárbara Chesman.
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>