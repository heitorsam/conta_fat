SELECT *
FROM V$SQLAREA area
WHERE area.PARSING_SCHEMA_NAME = 'HSSAMPAIO';

SELECT *
FROM ALL_TAB_COLUMNS atc
WHERE atc.COLUMN_NAME LIKE '%DESTINO%'
AND atc.OWNER = 'DBAMV'
ORDER BY 1 ASC;

SELECT *
FROM ALL_TAB_COLUMNS atc
WHERE atc.COLUMN_NAME LIKE '%DT_ENTRADA%'
AND atc.TABLE_NAME IN (SELECT TABLE_NAME FROM ALL_TAB_COLUMNS WHERE COLUMN_NAME LIKE '%ATENDIME%')
AND atc.OWNER = 'DBAMV'
ORDER BY 1 ASC

SELECT * FROM DBAMV.VDIC_RASTREAMENTO_PONTUARIO;

SELECT * FROM dbamv.REG_FAT ORDER BY 1 DESC;
SELECT * FROM Dbamv.PROTOCOLOS ORDER BY 1 DESC;
SELECT * FROM Dbamv.IT_SAME_PROTOCOLOS ORDER BY 1 DESC;
SELECT * FROM DBAMV.SAME ORDER BY DT_CADASTRO DESC;
SELECT * FROM dbamv.IT_SAME ORDER BY 1 DESC;
SELECT * FROM DBAMV.REG_FAT ORDER BY 1 DESC;
SELECT * FROM dbamv.ITREG_FAT ORDER BY 1 DESC;

SELECT * FROM dbamv.ATENDIME atd WHERE atd.CD_PACIENTE = 740618; --ATD 5046866

SELECT * FROM DBAMV.VDIC_RASTREAMENTO_PONTUARIO WHERE COD_ATENDIMENTO = 5046866;


SELECT itsm.CD_ATENDIMENTO
FROM dbamv.IT_SAME itsm
INNER JOIN dbamv.PORTADORES port
  ON port.CD_PORTADOR = itsm.CD_PORTADOR_ATUAL
INNER JOIN dbamv.ATENDIME atd
  ON atd.CD_ATENDIMENTO = itsm.CD_ATENDIMENTO 
WHERE atd.TP_ATENDIMENTO = 'I'
AND itsm.CD_ATENDIMENTO NOT IN (SELECT rf.CD_ATENDIMENTO 
                                FROM dbamv.REG_FAT rf 
                                WHERE rf.CD_ATENDIMENTO = itsm.CD_ATENDIMENTO
                                AND rf.CD_REMESSA IS NOT NULL)
AND TO_CHAR(atd.DT_ALTA,'DD/MM/YYYY') BETWEEN '18/05/2023' AND '18/05/2023'
AND itsm.CD_PORTADOR_ATUAL = 2     
 
