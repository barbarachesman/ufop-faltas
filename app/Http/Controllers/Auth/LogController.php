<?php

namespace App\Http\Controllers\Auth;

use App\Events\LdapiErrorOnLogin;
use App\Events\LoginFailed;
use App\Events\NewUserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Usuario;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Input;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

class LogController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Renderiza a view de login
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Determina se um usuário é capaz de usar o sistema ou não baseado no seu grupo.
     * @param $group ID do grupo o qual o usuário pertence
     * @return bool True se é autorizado a usar e False caso contrário
     */
    private function isPermittedProf($group)
    {
        return true;
        $permitted = false;

        // Se pertencer à algum grupo vinculado ao campus, está liberado
        switch ($group) {
            case 712: // Biblioteca ICEA
            case 714: // ICEA
            case 715: // DECEA
            case 716: // DEENP
            case 7126: // DECOM - Ouro Preto
            case 71130: // DECSI
            case 71481: // DEELT
                $permitted = true;
                break;
        }

        return $permitted;
    }
    private function isPermittedAluno($group)
    {
        return true;
        $permitted = false;

        // Se pertencer à algum grupo vinculado ao campus, está liberado
        switch ($group) {
            case 712: // Biblioteca ICEA
            case 714: // ICEA
            case 715: // DECEA
            case 716: // DEENP
            case 7126: // DECOM - Ouro Preto
            case 71130: // DECSI
            case 71481: // DEELT
                $permitted = true;
                break;
        }

        return $permitted;
    }
    /**
     * Realiza o processo de login de usuário.
     */
    public function postLogin(LoginRequest $request) {
        $input = Input::all();

        // Retirada dos pontos e hífen do CPF
        $input['username'] = str_replace('.', '', $input['username']);
        $input['username'] = str_replace('-', '', $input['username']);

        // Componentes do corpo da requisição
        $requestBody['user'] = $input['username'];
        $requestBody['password'] = $input['password'];
        $requestBody['attributes'] = ["cpf", "nomecompleto", "email", "id_grupo"]; // Atributos que devem ser retornados em caso autenticação confirmada

        // Chamada de autenticação para a LDAPI
        $httpClient = new Client();
        try
        {
            $response = $httpClient->request(Config::get('ldapi.requestMethod'), Config::get('ldapi.authUrl'), [
                "auth" => [Config::get('ldapi.user'), Config::get('ldapi.password'), "Basic"],
                "body" => json_encode($requestBody),
                "headers" => [
                    "Content-type" => "application/json",
                ],
            ]);
        }
        catch (ClientException $ex) { // Erros relacionados a autenticação
            $credentials['username'] = $input["username"];
            $credentials['password'] = $input['password'];

            Event::fire(new LoginFailed($credentials)); // Dispara um evento de falha de login

            $responseBody = $ex->getResponse()->getBody()->getContents();
            if(is_null($responseBody)) $requestBody = "Erro desconhecido.";

            return redirect()->back()->withErrors(['credentials' => $responseBody]);
        }
        catch (RequestException $ex) { // Erros relacionados ao servidor
            $credentials['username'] = $input["username"];
            $credentials['password'] = $input['password'];

            Event::fire(new LdapiErrorOnLogin($credentials)); // Dispara um evento de falha de login

            return redirect()->back()->withErrors(['server' => $ex->getResponse()->getBody()->getContents()]);
        }

        // Se nenhuma excessão foi jogada, então o usuário está autenticado
        $user = Usuario::where('cpf', $input['username'])->first();

        // Se o usuário é NULL então ou ele não é cadastrado no sistema ainda ou não tem permissão
        if(is_null($user))
        {
            // Recupera os atributos retornados pelo servidor de autenticação
            $userData = json_decode($response->getBody()->getContents());

            // Verificar se ele pertence a algum grupo que é permitido de usar o sistema, por exemplo
            if($this->isPermittedProf($userData->id_grupo))
            { // Se for permitido, então cria-se um novo usuário
                $user = Usuario::create([
                    'cpf' => $userData->cpf,
                    'email' => $userData->email,
                    'nome' => ucwords(strtolower($userData->nomecompleto)),
                    'id_grupo' =>$userData->id_grupo,
                ]);

                Event::fire(new NewUserCreated($user));
            }
            if($this->isPermittedAluno($userData->id_grupo))
            { // Se for permitido, então cria-se um novo usuário
                $user = Usuario::create([
                    'cpf' => $userData->cpf,
                    'email' => $userData->email,
                    'nome' => ucwords(strtolower($userData->nomecompleto)),
                    'id_grupo' =>$userData->id_grupo,
                    'ou' =>$userData->ou,
                ]);

                Event::fire(new NewUserCreated($user));
            }
            else return redirect()->back()->withErrors(['credentials' => 'Você não tem permissão para usar o sistema.']);
        }

        // Se o usuário selecionou a opção de ser lembrado,
        if(isset($input['remember-me']))  Auth::login($user, true); // Então ele deve ser lembrado
        else Auth::login($user); // Senão é um login ordinário

        // Redireciona para a página pretendida ou para a página inicial do sistema
        return redirect()->intended('/');
    }
}
