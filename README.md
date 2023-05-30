# lynx-shortner
Encurtador de URLs feito com PHP e Laravel no Backend em formato de REST API e VueJS no frontend

Desculpe pela confusão. Aqui está a documentação formatada em Markdown:

## LynxShortner API

Esta é a documentação da API do LynxShortner, que permite encurtar URLs e gerenciar links encurtados.

### Autenticação

A autenticação é necessária para acessar os endpoints da API. Todos os endpoints requerem um token de autenticação JWT no cabeçalho Authorization. Você deve adquirir um token de acesso fazendo uma solicitação de login.

#### Login [POST /api/login]

Autentica o usuário e retorna um token de acesso.

- URL: `[SERVER_URL]/api/login`
- Método: POST
- Headers:
  - Authorization: Bearer Token
- Corpo (form-data):
  - email: [email do usuário]
  - password: [senha do usuário]

### Redirecionar Link

Redireciona um link encurtado para a página original.

- URL: `[SERVER_URL]/r/:identifier`
- Método: GET
- Headers:
  - Authorization: Bearer Token
- Variáveis de Path:
  - identifier: [identificador do link]

### Adicionar Link

Adiciona um novo link encurtado.

- URL: `[SERVER_URL]/api/links/`
- Método: POST
- Headers:
  - Authorization: Bearer Token
- Corpo (form-data):
  - url: [URL original]
  - identifier: [identificador do link]

### Listar Links

Lista todos os links encurtados do usuário.

- URL: `[SERVER_URL]/api/links/`
- Método: GET
- Headers:
  - Authorization: Bearer Token

### Deletar Link

Remove um link encurtado.

- URL: `[SERVER_URL]/api/links/:id`
- Método: DELETE
- Headers:
  - Authorization: Bearer Token
- Variáveis de Path:
  - id: [ID do link]

### Editar Link

Edita um link encurtado existente.

- URL: `[SERVER_URL]/api/links/:id?url=[nova URL]&identifier=[novo identificador]`
- Método: PUT
- Headers:
  - Authorization: Bearer Token
- Variáveis de Path:
  - id: [ID do link]

### Visualizar Link

Visualiza os detalhes de um link encurtado.

- URL: `[SERVER_URL]/api/links/:id`
- Método: GET
- Headers:
  - Authorization: Bearer Token
- Variáveis de Path:
  - id: [ID do link]

Lembre-se de substituir "[SERVER_URL]" pelo endereço correto do seu servidor.