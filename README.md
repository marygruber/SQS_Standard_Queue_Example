# SQS_Standard_Queue_Example
SQS Standard Queue Example

###### Este exemplo tem por finalidade:
* Criar uma fila tipo Standard
* Deletar a fila criada
* Enviar mensagens para a fila criada (por padrão, são enviadas 10 mensagens com textos aleatórios)
* Ler as mensagens da fila criada, de 5 em 5 segundos
* Após a leitura, cada mensagem é deletada da lista

###### Config inicial:
* Informar a região no aquivo de configuração `config/sqsClient.env`
* Informar o nome da Queue que será criada no arquivo de configuração `config/queue.env`, bem como o nome do autor.
  * Após criada a queue, neste mesmo arquivo informar a URL da queue criada.
  
***!!Antes de executar os comandos abaixo, deve ser feita a configuração com suas chaves de acesso da AWS. Para tal, digite no terminal `aws configure` e informe suas credenciais!!***
  
 ###### Criando uma Queue:
  `php manage/createQueue.php`
    
 ###### Enviando mensagens:
  `php producer/sendMessages.php`
  
 ###### Receber/consumir mensagens:
  `php consumer/receiveMessage.php`
  
  ###### Deletar a queue:
  `php manage/deleteQueue.php`
    
 ###### Recuperar a URL da queue criada:
   `php manage/getQueueUrl.php`
