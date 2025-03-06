# GERADOR DE CURRÍCULOS

Este projeto foi desenvolvido com o objetivo de demonstrar minhas habilidades em tecnologias como PHP, MySQL, Programação Orientada a Objetos (POO), React e Bootstrap.

Trata-se de um sistema gerador de currículos, onde os usuários podem:

- Criar uma conta com login e senha para acessar a plataforma.
- Cadastrar e gerenciar seus currículos de forma intuitiva e personalizada.
- Editar e modificar as informações dos currículos conforme necessário, garantindo flexibilidade e praticidade.

O sistema foi projetado para ser responsivo e fácil de usar, proporcionando uma experiência agradável tanto para usuários quanto para desenvolvedores. Além disso, a integração entre o backend (PHP/MySQL) e o frontend (React/Bootstrap) foi cuidadosamente implementada para garantir um fluxo de dados eficiente e uma interface moderna.

## Controllers

### CurriculoController

#### Atributos

- **curriculo:** Recebe o model Curriculo.
- **experiencia:** Recebe o model Experiencia.
- **request:** Recebe os inputs.

#### Métodos

- **pegarTodos:** Lista todos os currículos.
- **pegarPorCurriculoPorUsuarioId:** Lista todos os currículos fazendo uma paginação, onde o usuario_id é igual ao parâmetro (usuario_id).
- **pegarPorId:** Lista o currículo pelo parâmetro (id).
- **cadastrar:** Faz as validações e cadastra o currículo.
- **editar:** Faz as validações e edita o currículo.
- **excluir:** Faz as validações e exclui o currículo.

### ExperienciaController

#### Atributos

- **experiencia:** Recebe o model Experiencia.
- **request:** Recebe os inputs.

#### Métodos

- **pegarTodos:** Lista todas as experiências.
- **pegarTodosPorCurriculoId:** Lista todos os currículos pelo parâmetro (id).
- **pegarTodosPorCurriculoIdPaginacao:** Lista todas as experiências fazendo uma paginação, onde o curriculo_id é igual ao parâmetro (id).
- **pegarPorId:** Lista a experiência pelo parâmetro (id).
- **cadastrar:** Faz as validações e cadastra a experiência.
- **editar:** Faz as validações e edita a experiência.
- **excluir:** Faz as validações e exclui a experiência.

### UsuarioController

#### Atributos

- **usuario:** Recebe o model Usuario.
- **request:** Recebe os inputs.

#### Métodos

- **login:** Faz o login.
- **recuperarSenha:** Faz as validações e recupera a senha.
- **verificaremail:** Verifica se o email existe.
- **cadastrar:** Faz as validações e cadastra o usuário.

## Models

### Curriculo

#### Atributos

- **banco:** Recebe o banco com a conexão.
- **tabela:** Recebe o valor "curriculo".

#### Métodos

- **pegarTodos:** Lista todos os currículos.
- **pegarPorCurriculoPorUsuarioId:** Lista todos os currículos fazendo uma paginação, onde o usuario_id é igual ao parâmetro (usuario_id).
- **pegarPorId:** Lista o currículo pelo parâmetro (id).
- **cadastrar:** Faz as validações e cadastra o currículo.
- **editar:** Faz as validações e edita o currículo.
- **excluir:** Faz as validações e exclui o currículo.

### Experiencia

#### Atributos

- **banco:** Recebe o banco com a conexão.
- **tabela:** Recebe o valor "experiencia".

#### Métodos

- **pegarTodos:** Lista todas as experiências.
- **pegarTodosPorCurriculoId:** Lista todos os currículos pelo parâmetro (id).
- **pegarTodosPorCurriculoIdPaginacao:** Lista todas as experiências fazendo uma paginação, onde o curriculo_id é igual ao parâmetro (id).
- **pegarPorId:** Lista a experiência pelo parâmetro (id).
- **cadastrar:** Faz as validações e cadastra a experiência.
- **editar:** Faz as validações e edita a experiência.
- **excluir:** Faz as validações e exclui a experiência.

### Usuario

#### Atributos

- **banco:** Recebe o banco com a conexão.
- **tabela:** Recebe o valor "usuario".

#### Métodos

- **recuperarSenha:** Faz o update da senha pelo email.
- **verificaremail:** Retorna os dados de (email e senha).
- **cadastrar:** Faz as validações e cadastra o usuário.

## Validações

- **Validação:** Faz as validações gerais dos inputs.
- **ValidaçãoCurriculo:** Faz as validações dos inputs do controller (CurriculoController).
- **ValidaçãoImagem:** Faz o upload das imagens e valida tamanho e tipo de arquivo.

## Banco

### Em Models

- **Banco:** Faz a conexão com o banco de dados.

- ## Rotas

### Rotas de Usuário

#### GET /

- **Descrição:** Retorna a página inicial.
- **Resposta:** "Página inicial" em formato JSON.

#### POST /cadastrar

- **Descrição:** Cadastra um novo usuário.
- **Controller:** UsuarioController
- **Método:** cadastrar()
- **Resposta:** Depende da implementação do método cadastrar().

#### POST /login

- **Descrição:** Realiza o login de um usuário.
- **Controller:** UsuarioController
- **Método:** login()
- **Resposta:** Depende da implementação do método login().

#### POST /recuperarsenha

- **Descrição:** Inicia o processo de recuperação de senha.
- **Controller:** UsuarioController
- **Método:** recuperarSenha()
- **Resposta:** Depende da implementação do método recuperarSenha().

#### POST /verificaremail

- **Descrição:** Verifica se um email já está cadastrado.
- **Controller:** UsuarioController
- **Método:** verificaremail()
- **Resposta:** Depende da implementação do método verificaremail().

### Rotas de Currículo

#### GET /curriculo/[i:usuario_id]

- **Descrição:** Retorna o currículo de um usuário específico pelo ID do usuário.
- **Controller:** CurriculoController
- **Método:** pegarPorCurriculoPorUsuarioId($usuario_id)
- **Resposta:** Depende da implementação do método pegarPorCurriculoPorUsuarioId($usuario_id).

#### GET /curriculoid/[i:id]

- **Descrição:** Retorna um currículo específico pelo ID do currículo.
- **Controller:** CurriculoController
- **Método:** pegarPorId($id)
- **Resposta:** Depende da implementação do método pegarPorId($id).

#### GET /curriculos

- **Descrição:** Retorna todos os currículos cadastrados.
- **Controller:** CurriculoController
- **Método:** pegarTodos()
- **Resposta:** Depende da implementação do método pegarTodos().

#### POST /cadastrar/curriculo

- **Descrição:** Cadastra um novo currículo.
- **Controller:** CurriculoController
- **Método:** cadastrar()
- **Resposta:** Depende da implementação do método cadastrar().

#### POST /editar/curriculo

- **Descrição:** Edita um currículo existente.
- **Controller:** CurriculoController
- **Método:** editar()
- **Resposta:** Depende da implementação do método editar().

#### OPTIONS /excluircurriculo

- **Descrição:** Exclui um currículo.
- **Controller:** CurriculoController
- **Método:** excluir()
- **Resposta:** Depende da implementação do método excluir().

### Rotas de Experiências

#### GET /experienciaspaginacao/[i:id]

- **Descrição:** Retorna todas as experiências de um currículo específico com paginação.
- **Controller:** ExperienciaController
- **Método:** pegarTodosPorCurriculoIdPaginacao($id)
- **Resposta:** Depende da implementação do método pegarTodosPorCurriculoIdPaginacao($id).

#### GET /experiencias/[i:id]

- **Descrição:** Retorna todas as experiências de um currículo específico.
- **Controller:** ExperienciaController
- **Método:** pegarTodosPorCurriculoId($id)
- **Resposta:** Depende da implementação do método pegarTodosPorCurriculoId($id).

#### GET /experiencia/[i:id]

- **Descrição:** Retorna uma experiência específica pelo ID.
- **Controller:** ExperienciaController
- **Método:** pegarPorId($id)
- **Resposta:** Depende da implementação do método pegarPorId($id).

#### POST /cadastrar/experiencia

- **Descrição:** Cadastra uma nova experiência.
- **Controller:** ExperienciaController
- **Método:** cadastrar()
- **Resposta:** Depende da implementação do método cadastrar().

#### POST /editar/experiencia

- **Descrição:** Edita uma experiência existente.
- **Controller:** ExperienciaController
- **Método:** editar()
- **Resposta:** Depende da implementação do método editar().

#### DELETE /excluirexperiencia

- **Descrição:** Exclui uma experiência.
- **Controller:** ExperienciaController
- **Método:** excluir()
- **Resposta:** Depende da implementação do método excluir().
