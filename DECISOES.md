# Decisões

## Tema

Optei por uma agência de viagens porque o domínio comporta as duas frentes que eu pretendia demonstrar: uma área pública com foco em apresentação e uma área interna com cadastro, filtros e fluxo de trabalho. O orçamento conecta as duas: o visitante solicita pelo site, a equipe responde pelo painel e o solicitante recebe o retorno por e-mail.

## Stack

- **Laravel 13**: já possuía familiaridade com o framework, que também oferece de forma nativa os recursos mais utilizados no projeto, como autenticação, validação, envio de e-mails, migrations e tradução.
- **Blade com Alpine.js**: optei por não adotar uma SPA. A maior parte das telas é conteúdo renderizado no servidor, e o Alpine atende adequadamente os pontos interativos existentes, como carrossel, modais, selects e tabelas em ajax.
- **Tailwind CSS 4**: a identidade visual é bastante específica, e o Tailwind permitiu construí-la sem manter uma base de CSS paralela.
- **MySQL**: banco relacional, suficiente para o modelo de dados do projeto.
- **tippy.js e flatpickr**: bibliotecas consolidadas para tooltip e seleção de datas, preferidas em vez de implementações próprias.

## Decisões de projeto

- Defini um documento de convenções do repositório e mantive sua aplicação ao longo do desenvolvimento: uso exclusivo de comentários phpDoc, organização das views por domínio com componentes próprios, views recebendo dados já tratados e scripts específicos de página isolados na stack daquela página.
- As telas do painel operam via ajax mantendo a URL sincronizada, de modo que um conjunto de filtros aplicado possa ser copiado e compartilhado.
- A criação de usuários não define senha. O novo integrante recebe um convite por e-mail e cadastra a própria senha, evitando a circulação de credenciais provisórias.

## Uso de inteligência artificial

Utilizei IA como apoio ao desenvolvimento durante todo o projeto, revisando o resultado antes de incorporá-lo.

**Atividade delegada integralmente.** Os testes automatizados foram a parte que deleguei por completo, por ser a área em que tenho menos prática. Solicitei a cobertura dos fluxos principais, solicitação de orçamento, autenticação, bloqueio de acesso, convite de usuário, resposta ao orçamento e filtros da listagem, acompanhada da explicação do que cada teste verifica. O trabalho identificou uma falha real na prevenção de orçamentos duplicados, que não se manifestava em MySQL e apareceria em outro banco de dados.

**Ajustes e correções de rumo.** Em diversos pontos foi necessário corrigir a abordagem proposta ou indicar um caminho mais adequado:

- A tendência inicial era reimplementar comportamentos do zero. Orientei que fossem utilizados os recursos já oferecidos pelo framework.
- Na construção do modal de filtros, foram criados campos novos. Indiquei que os componentes de select e calendário já existentes deveriam ser reaproveitados.
- A página institucional exibia um número fixo de destinos. Apontei que a informação deveria ser obtida da tabela de destinos.
- Diversos ajustes de interface foram solicitados explicitamente, entre eles a remoção do grid de pontos na listagem, a substituição dos botões de edição e exclusão por ícones com tooltip, a redução do componente de switch e a adoção de um diálogo próprio de confirmação em lugar do recurso nativo do navegador.

Também realizei alterações diretamente no código quando isso era mais eficiente do que descrever o ajuste, como na padronização do prefixo das rotas administrativas.

A concepção do produto e as decisões de arquitetura são de minha autoria. A IA atuou como acelerador de escrita, sobretudo em trechos repetitivos como traduções, componentes de interface e testes.
