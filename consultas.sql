
-- Junta a tabela de pergunta com resposta e busca todas as respostas das perguntas

SELECT perguntas.texto_perg , respostas.texto_resp from perg_resp INNER JOIN respostas on respostas.id_resp = perg_resp.fk_resp INNER JOIN perguntas on perguntas.id_perg = perg_resp.fk_perg;

SELECT perguntas.texto_perg , respostas.texto_resp from perg_resp, respostas, perguntas where perguntas.id_perg = perg_resp.fk_perg and respostas.id_resp = perg_resp.fk_resp;

SELECT perg_resp.id_rela, perguntas.texto_perg , respostas.texto_resp from perg_resp, respostas, perguntas where perguntas.id_perg = perg_resp.fk_perg and respostas.id_resp = perg_resp.fk_resp and texto_perg like '%nome%' order by RAND() LIMIT 1;

