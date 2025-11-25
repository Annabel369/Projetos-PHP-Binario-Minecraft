# Projetos-PHP-Binario-Minecraft

<img width="1152" height="648" alt="AND GATE" src="https://github.com/user-attachments/assets/6cf793fa-775c-4205-9539-99803d3960e2" />


Opcode,Instrução,I3,I2,I1,I0,ACC_LOAD,ALU_SUB
0010,ADD,0,0,1,0,1,0
0011,SUB,0,0,1,1,1,1
Outras,N/A,(x),(x),(x),(x),0,0


Bloco 1: Sincronismo e Busca (Clock & Fetch)⏱ 
Clock (NE555)→ Pulso CLK (Fio Amarelo) →74HC161 
(PC)→ Endereço (4 bits, Fios Laranja) →74HC154 (Decoder)$\downarrow$ Sinal de Ativação 
Módulo I: PC,Módulo II: Memória,Módulo III: Controle,Módulo IV: Registros,Módulo V: ALU,Módulo VI: Acumulador/Saída
NE555 (Clock),DIP Switches,74HC04 (NOT),74HC574 (Reg A),74LS181 (ALU),74HC574 (ACC)
74HC161 (PC),(Instruções),74HC08 (AND),74HC574 (Reg B),(Controle Sub),LEDs de Saída
74HC154 (Decoder),,74HC32 (OR),,,
Saída Laranja (Endereço),Saída Cinza (Opcode),Saída Vermelho Fino (Controle),Saída Verde Claro (Dados),Saída Azul Claro (Resultado),Saída Azul Escuro (Display)

(1 de 16)Memória (DIP Switches)

Módulo,CIs (Chips),Função Principal,Cor dos Fios de Saída (Dados)
I. Busca,74HC161 (PC),Gera o Endereço (A0-A3),Laranja
II. Memória,DIP Switches (Memória),Define o Opcode (I0-I3),Cinza/Branco


III. Controle,"74HC04, 74HC08, 74HC32 (UC)",Decodifica Opcode e gera Sinais de Controle,Vermelho Fino/Marrom (Controle)
IV. Dados (Registros),2x 74HC574 (Reg A e Reg B),Armazenam Operandos A e B,Verde Claro
V. Execução (ALU),74LS181 (ALU),Executa A + B ou A - B,Azul Claro
VI. Saída,74HC574 (Acumulador) + LEDs,Armazena e Exibe o Resultado,Azul Escuro

Módulo I: PC	Módulo II: Memória	Módulo III: Controle	Módulo IV: Registros	Módulo V: ALU	Módulo VI: Acumulador/Saída
NE555 (Clock)	DIP Switches	74HC04 (NOT)	74HC574 (Reg A)	74LS181 (ALU)	74HC574 (ACC)
74HC161 (PC)	(Instruções)	74HC08 (AND)	74HC574 (Reg B)	(Controle Sub)	LEDs de Saída
74HC154 (Decoder)		74HC32 (OR)			
Saída Laranja (Endereço)	Saída Cinza (Opcode)	Saída Vermelho Fino (Controle)	Saída Verde Claro (Dados)	Saída Azul Claro


🖍️ Legenda dos Fios (JAP)
Para não se perder na montagem, use estas cores para os fios rígidos (jumpers):

🔴 Vermelho / Preto: Alimentação (+5V e GND).

🟡 Amarelo: Clock (sai do 555 e vai para todos os chips de memória/registro).

⚪ Cinza/Branco: Instruções (Opcode) da Memória para a Unidade de Controle.

🟢 Verde: Dados crus (saída dos Registradores A e B indo para a ALU).

🔵 Azul: Resultado (saída da ALU indo para o Acumulador e LEDs).

🟠 Laranja: Endereçamento (do PC para a Memória

================ LINHA DE FORÇA +5V (VERMELHO) =================
|                                                              |
|   [ MÓDULO 1: CLOCK ]         [ MÓDULO 2: MEMÓRIA ]          |
|   +---------------+           +-------------------+          |
|   |   NE555       |---------->|  DIP SWITCHES     |          |
|   | (Gera Pulso)  |   (Fio    | (Define Instrução)|          |
|   +-------|-------+  Amarelo) +---------|---------+          |
|           |                             |                    |
|           v                             v (Fio Cinza)        |
|   +---------------+           +-------------------+          |
|   |   PC (Cont.)  |           | UNIDADE CONTROLE  |          |
|   |   74HC161     |           | (74HC08, 04, 32)  |          |
|   +-------|-------+           +---------|---------+          |
|           |                             | (Fios Vermelhos)   |
|           | (Endereço)                  | Sinais de Controle |
|           v                             v                    |
|                                                              |
|   [ MÓDULO 3: DADOS ]         [ MÓDULO 4: CÁLCULO ]          |
|   +---------------+           +-------------------+          |
|   | REG A (574)   |---------->|                   |          |
|   +---------------+ (Verde)   |   ALU (74LS181)   |          |
|                               |   (Soma/Subtrai)  |          |
|   +---------------+ (Verde)   |                   |          |
|   | REG B (574)   |---------->|                   |          |
|   +---------------+           +---------|---------+          |
|           ^                             |                    |
|           | (Enable)                    | (Fio Azul Claro)   |
|           |                             v                    |
|           |                   +-------------------+          |
|           L-------------------| ACUMULADOR (ACC)  |          |
|                               |     74HC574       |          |
|                               +---------|---------+          |
|                                         |                    |
|                                         v (Fio Azul Escuro)  |
|                               [   LEDs DE SAÍDA   ]          |
|                               ( O   O   O   O   O )          |
|                                                              |
================ LINHA DE TERRA GND (PRETO/AZUL) ===============
