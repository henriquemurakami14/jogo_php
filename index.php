    <?php 
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

           date_default_timezone_set("America/Sao_Paulo");
           print str_repeat("-", 20) . " BEM-VINDOS AO NÚMERO MISTERIOSO GAME " . str_repeat("-", 20) . "\n";
            // INTRODUÇÃO

            do{
            $min = readline("Vamos criar um intervalo! Digite para mim o intevalo mínimo dos números: ");
            $min = readline_int($min);
            }while(!is_numeric($min) || (int)$min < 0);
            
            do{
            $max = readline("Agora digite o intervalo máximo dos números: ");
            $max = readline_int($max);
            }while(!is_numeric($max) || $max <= $min);
            

            $numero_enemy = rand($min, $max);

            do {
                $numero_tentativas = readline("Quantas chances você vai precisar? ");
                readline_int($numero_tentativas);
            } while(!is_numeric($numero_tentativas) || (int)$numero_tentativas <= 0);
                    
            $contador = 0;

        do{
            $acabou_partida = false;
            $contador++;

            do{
                $numero_host = readline("CHANCE NÚMERO $contador! Escreva um número entre $min a $max: ");
                readline_int($numero_host);
            }while((!is_numeric($numero_host)) || ($numero_host < $min || $numero_host > $max));
            

            if($numero_host == $numero_enemy){
                echo "\nVocê acertou o número escolhido em $contador chances! O número misterioso era $numero_enemy! \n";

                $ver_ranking = strtoupper(readline("Digite [S] para salvar sua jogada e [N] para não salvar: "));
                do{
                    
                    if ($ver_ranking == "S") {
                        ranking($contador, $min, $max);
                        break;
                    }elseif ($ver_ranking == "N") {
                        print "Obrigado por participar!";
                        break;
                    }elseif($ver_ranking != "S" || $ver_ranking != "N"){
                        $ver_ranking = readline("Digite novamente: ");
                    }
                }while($ver_ranking != "S" || $ver_ranking != "N");
    
                $acabou_partida = true;
            }
            else{
                echo "O número $numero_host está errado! Tente novamente! ";
                if ($numero_host > $numero_enemy) {
                    print "O número certo é mais baixo!\n";
                }
                elseif ($numero_host < $numero_enemy) {
                    print "O número certo é mais alto!\n";
                }
            if($contador >= $numero_tentativas){
                print "\nAcabou as suas $numero_tentativas tentativas infelizmente! Você perdeu o número era $numero_enemy!";
                $acabou_partida = true;
            }
            }
        }while(!$acabou_partida);

        function readline_int(&$variavel){
            $validado = false;
            do {
                if (filter_var($variavel, FILTER_VALIDATE_INT) != false) {
                    return (int)$variavel;
                    $validado = true;
                
                }elseif($variavel == "0"){
                    return (int)0;
                    $validado = true;
                }else {
                    $variavel = readline("Erro, digite um número inteiro! Digite novamente: ");
                }
            } while (!$validado);
        }

        function ranking($numero_tentativas, $min, $max){
            $ranking = file_get_contents("ranking.json");
            $ranking = json_decode($ranking);

            $nome = readline("Digite seu nome? ");
            $tentativas = $numero_tentativas;
            $pontos = $max - $min;

            $ranking[] = ["NOME " . $nome . " | PONTOS " . $pontos . " | TENTATIVAS " . $tentativas. " | DATA ". date("Y-m-d H:i:s")];

            $json = json_encode($ranking, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            file_put_contents("ranking.json", $json);

            $tamanho_ranking = count($ranking);

            for ($i = 0; $i < $tamanho_ranking ; $i++) { 
                print $ranking[$i][0] . "\n";
            }

        }
        
    ?>