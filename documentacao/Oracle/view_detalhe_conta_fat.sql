CREATE OR REPLACE VIEW conta_fat.VDIC_DETALHE_CONTA_FAT AS 

SELECT tot.*, pac.NM_PACIENTE
FROM(
SELECT res.*,
ultmv.CD_PORTADOR AS CD_PORTADOR_ORIGEM, ultmv.DS_PORTADOR AS DS_PORTADOR_ORIGEM,
CASE 
  WHEN res.CD_PORTADOR_ATUAL = 7 AND ultmv.CD_PORTADOR = 2 THEN 'S'
  ELSE 'N'
END AS SN_ALERTA
FROM(
SELECT itsm.CD_ATENDIMENTO, TO_CHAR(atd.DT_ALTA,'DD/MM/YYYY') AS DT_ALTA, 
unid.CD_UNID_INT, unid.DS_UNID_INT,
itsm.CD_PORTADOR_ATUAL, port.DS_PORTADOR AS DS_PORTADOR_ATUAL
FROM dbamv.IT_SAME itsm
INNER JOIN dbamv.PORTADORES port
  ON port.CD_PORTADOR = itsm.CD_PORTADOR_ATUAL
INNER JOIN dbamv.ATENDIME atd
  ON atd.CD_ATENDIMENTO = itsm.CD_ATENDIMENTO
INNER JOIN dbamv.LEITO lt
  ON lt.CD_LEITO = atd.CD_LEITO
INNER JOIN dbamv.UNID_INT unid
  ON unid.CD_UNID_INT = lt.CD_UNID_INT     
WHERE atd.TP_ATENDIMENTO = 'I'
AND itsm.CD_ATENDIMENTO NOT IN (SELECT rf.CD_ATENDIMENTO 
                                FROM dbamv.REG_FAT rf 
                                WHERE rf.CD_ATENDIMENTO = itsm.CD_ATENDIMENTO
                                AND rf.CD_REMESSA IS NOT NULL)
AND TO_CHAR(atd.DT_ALTA,'DD/MM/YYYY') >= '01/01/2023'
AND itsm.CD_PORTADOR_ATUAL IN (2,7,8,37)) res
INNER JOIN (SELECT pro.*, ipro.CD_ATENDIMENTO, ppt.DS_PORTADOR
            FROM dbamv.PROTOCOLOS pro
            INNER JOIN dbamv.IT_SAME_PROTOCOLOS ipro
              ON ipro.CD_PROTOCOLO = pro.CD_PROTOCOLO
            INNER JOIN dbamv.PORTADORES ppt
              ON ppt.CD_PORTADOR = pro.CD_PORTADOR
            WHERE ipro.CD_PROTOCOLO IN (SELECT aux.CD_PROTOCOLO 
                                        FROM  (SELECT CD_ATENDIMENTO, MAX(CD_PROTOCOLO) AS CD_PROTOCOLO
                                              FROM dbamv.IT_SAME_PROTOCOLOS 
                                              GROUP BY CD_ATENDIMENTO) aux)) ultmv
  ON ultmv.CD_ATENDIMENTO = res.CD_ATENDIMENTO) tot
INNER JOIN dbamv.ATENDIME atd
  ON atd.CD_ATENDIMENTO = tot.CD_ATENDIMENTO
INNER JOIN dbamv.PACIENTE pac
  ON pac.CD_PACIENTE = atd.CD_PACIENTE;

SELECT dc.*
FROM conta_fat.VDIC_DETALHE_CONTA_FAT dc
WHERE dc.DT_ALTA BETWEEN '18/05/2023' AND '18/05/2023'
AND dc.CD_PORTADOR_ATUAL = 7;  
