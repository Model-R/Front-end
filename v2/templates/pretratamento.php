<link rel="stylesheet" href="css/tabModal.css">

<div class="modal fade" id="preTratamentoModal" tabindex="-1" role="dialog" aria-labelledby="preTratamentoLabel" aria-hidden="true">
    <div class="tab-modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="preTratamentoLabel">Pré-tratamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="tab-modal-body modal-body">
                <p>
					Etapa de aquisição, verificação e limpeza de dados, utilizando filtros geográficos para
					marcar os registros potencialmente errado e ferramentas para verificação e remoção de
					multicolinearidade na seleção das variáveis preditoras.
				</p>
				<p>
					Nessa etapa são realizadas (1) a aquisição de dados bióticos, a partir das bases de dados:
					JABOT, GBIF, SiBBr, ou fazendo o upload de um arquivo csv. E a (2) aquisição de
					dados abióticos, a partir das bases de dados: Bio-Oracle, Wordclim 1.4 (série histórica
					anos 1960-1990) e 2.0 (série histórica anos 1970-2000). Ainda no pré-processamento, é
					possível realizar a limpeza de dados bióticos, utilizando os filtros: coordenadas com
					zero; duplicatas; fora do limite do Brasil e fora do limite de coleta.
				</p>
            </div>
        </div>
    </div>
</div>