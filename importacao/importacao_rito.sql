// ALTERAÇÃO DO IDSUBORDINACAO PARA A TABELA CORPO

update corpo set idsubordinacao = sub.idcorpo
from  
corpo sub
where 
corpo.codsub <> '' and
sub.idtipocorpo = cast(substring(corpo.codsub from 1 for 1) as int) and
sub.codcorpo = substring(corpo.codsub from 2 for 4)

// FUNCAO E O TRIGGER PARA ATUALIZAR O ULTIMO ANO DE PAGAMENTO DE UM CORPO. DIRETAMENTE NA TABELA DE CORPO


CREATE OR REPLACE FUNCTION atualiza_ano_pagto_corpo() 
RETURNS trigger LANGUAGE plpgsql
AS
    'begin 
update corpo set ultimoanopagto = (select max(anopagamento) from  atividadecorpo
where idcorpo = new.idcorpo) 
where
idcorpo = new.idcorpo;
return new;
    end; ';


CREATE TRIGGER tg_atualiza_ano_pagto_corpo AFTER INSERT
ON atividadecorpo FOR EACH ROW    
      EXECUTE PROCEDURE atualiza_ano_pagto_corpo();