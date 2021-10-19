document.write("TESTE");

const getCliente = async ( url ) => fetch ( url ).then ( res => res.json() );

const teste = async() =>{
  const url = `http://kingofservices.com.br/PesquisarPrestador/programador`;
  const client = await getCliente(url);
  client.forEach(element => {
    console.log(element.nome, element.nomeProfissao + "\n\n")
  });
  console.log(typeof client)
}

teste();


