from langchain_core.vectorstores import InMemoryVectorStore
from langchain_google_genai import ChatGoogleGenerativeAI
from langchain_core.output_parsers import StrOutputParser
from langchain_huggingface import HuggingFaceEmbeddings
from fastapi.middleware.cors import CORSMiddleware
from langchain.prompts import PromptTemplate
from langchain.text_splitter import CharacterTextSplitter
from dotenv import load_dotenv
from fastapi import FastAPI, File, UploadFile, Form
from PyPDF2 import PdfReader
load_dotenv()
import time
app = FastAPI()
llm = ChatGoogleGenerativeAI(model='gemini-1.5-flash')

#funcionamento da api com o laravel
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # ou ex: ["http://127.0.0.1:8000"]
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/new_topic_folder/{topico}")
def new_topic_folder(topico):
        
    prompt_mateira = PromptTemplate(
        input_variables=['topico'],
        template='''Quero que retorne apenas a matéria desse tópico {topico}.
        Quero apenas o nome da matéria, nada mais.
        Exemplo: Segunda guerra mundial - Hístoria, Algebra linear - Matemática'''
    )
    chain_materia = prompt_mateira | llm | StrOutputParser()
    materia_topico = chain_materia.invoke({'topico': topico})
    
    prompt_resumo = PromptTemplate(
        input_variables=['topico'],
        template='''Quero que retorne apenas o resumo da matéria {topico}.
        De até 7 palavras
        Quero apenas o resumo da matéria, nada mais.
        Exemplo: Biologia - Estudos sobre células, genética e sistemas do corpo humano.
        ''')
    chain_resumo = prompt_resumo | llm | StrOutputParser()
    resumo = chain_resumo.invoke({'topico': topico})
    
    sobre = resumo_topico(topico)
    topics = topicos(topico)
    materiais = material(topico)
    
    return materia_topico,resumo,sobre,topics,materiais


def resumo_topico(topico):
    prompt_topic = PromptTemplate(
        input_variables=['topico'],
        template='''Você é um professor experiente de {topico} com mais de 15 anos em sala de aula.
        Faça um resumo objetivo sobre {topico}
        - Tópicos essenciais para um estudante dominar
        - Aplicações práticas quando relevante

        Seja direto e use linguagem clara. Evite introduções desnecessárias ou conclusões. Organize o conteúdo em tópicos concisos para facilitar a compreensão.
        Sem introduções ou despedidas. Apenas o conteúdo solicitado em formato conciso e direto.
        '''
    )

    # print(prompt.format_prompt())
    chain_topic = prompt_topic | llm | StrOutputParser()
    response = chain_topic.invoke({'topico': topico})
    return response

def topicos(topico):
    prompt_translate_topico = PromptTemplate(
        input_variables=["topico"],
        template='''Você é um especialista em {topico} com vasta experiência acadêmica e prática.

        Crie uma lista estruturada de 9 tópicos essenciais sobre {topico}, organizados por nível de complexidade:

        Nível Iniciante (Fundamentos)
        Liste 3 tópicos fundamentais que todo iniciante deve dominar primeiro, explicando brevemente por que são importantes e o que abrangem. Inclua conceitos básicos e terminologias introdutórias.

        Nível Intermediário (Aprofundamento)
        Liste 3 tópicos para quem já possui conhecimentos básicos e deseja aprofundar sua compreensão. Explique como estes tópicos se conectam aos fundamentos e expandem o conhecimento prático.

        Nível Avançado (Especialização)
        Liste 3 tópicos complexos para praticantes experientes, destacando aplicações sofisticadas, técnicas especializadas ou desenvolvimentos recentes na área.
        '''
    )
            
    chain = prompt_translate_topico | llm | StrOutputParser()
    response = chain.invoke({f'topico': topico})
    return response

@app.get('/material/{topico}')
def material(topico):
    levels = ['iniciante', 'intermediario', 'avancado']
    content_level = []
    
    for level in levels:
        # Ajuste o template conforme o nível
        if level == 'iniciante':
            template_text = '''Você é um professor experiente de {topico} com mais de 15 anos em sala de aula.

            Crie um guia sobre {topico} para INICIANTES ABSOLUTOS. Seu texto deve:

            1. Explicar o que é {topico} em termos muito simples e acessíveis
            2. Cobrir apenas os conceitos mais fundamentais e básicos
            3. Usar analogias e exemplos do cotidiano para facilitar a compreensão
            4. Explicar terminologias básicas como se falasse com alguém que nunca teve contato com o assunto
            5. Abordar erros comuns de iniciantes e como evitá-los
            6. Sugerir exercícios simples para praticar os conceitos iniciais

            Use linguagem extremamente simples e direta. Evite completamente jargões técnicos. Organize o conteúdo em tópicos bem definidos. Mantenha explicações concisas e amigáveis para iniciantes.

            Não inclua introduções formais ou conclusões. Concentre-se apenas no conteúdo educacional.
            '''
        elif level == 'intermediario':
            template_text = '''Você é um professor experiente de {topico} com mais de 15 anos em sala de aula.

            Crie um guia sobre {topico} para estudantes de NÍVEL INTERMEDIÁRIO. Seu texto deve:

            1. Aprofundar conceitos que vão além do básico, assumindo que o leitor já domina os fundamentos
            2. Explorar conexões entre diferentes conceitos dentro de {topico}
            3. Apresentar exemplos mais complexos e aplicações práticas
            4. Introduzir terminologias mais técnicas, explicando-as adequadamente
            5. Discutir estratégias para superar desafios comuns neste nível
            6. Propor exercícios de dificuldade média que exigem combinação de conceitos

            Use linguagem clara mas mais técnica que para iniciantes. Organize o conteúdo em tópicos bem estruturados com subtópicos quando necessário. Aprofunde as explicações sem se tornar excessivamente complexo.

            Não inclua introduções formais ou conclusões. Concentre-se apenas no conteúdo educacional.
            '''
        else:  # avançado
            template_text = '''Você é um professor experiente de {topico} com mais de 15 anos em sala de aula.

            Crie um guia sobre {topico} para estudantes de NÍVEL AVANÇADO. Seu texto deve:

            1. Abordar conceitos complexos e avançados, assumindo sólido conhecimento intermediário
            2. Explorar nuances, exceções e casos especiais dentro de {topico}
            3. Apresentar aplicações sofisticadas e casos de uso profissionais
            4. Utilizar terminologia técnica avançada apropriada para especialistas
            5. Discutir pesquisas recentes ou desenvolvimentos na área quando relevante
            6. Propor desafios e problemas complexos que exigem domínio profundo do assunto

            Use linguagem técnica apropriada para especialistas. Organize o conteúdo em tópicos detalhados com análise aprofundada. Não simplifique excessivamente - assuma que o leitor busca domínio completo.

            Não inclua introduções formais ou conclusões. Concentre-se apenas no conteúdo educacional.
            '''

        prompt_material = PromptTemplate(
            input_variables=["topico"],
            template=template_text
        )

        chain_material = prompt_material | llm | StrOutputParser()
        content = chain_material.invoke({"topico": topico})
        print(content)
        
        content_level.append({level: content})
    print(content_level)
    return content_level

@app.get('/add_material/{topico}/{descricao}/{nivel}')
def add_material(topico, descricao, nivel):
    material = []
    prompt_template = PromptTemplate(
        input_variables=['topico', 'descricao', 'nivel'],
        template='''
Você é um especialista na área de {topico} e precisa criar um material didático de nível {nivel} com base na seguinte descrição:
"{descricao}"

Elabore um texto explicativo que:
- Aborde os pontos principais da descrição;
- Seja claro, objetivo e adequado ao nível {nivel};     
no seu texto deve ter:
1. Aprofundar conceitos que vão além do básico, assumindo que o leitor já domina os fundamentos
2. Explorar conexões entre diferentes conceitos dentro de {topico}
3. Apresentar exemplos mais complexos e aplicações práticas
4. Introduzir terminologias mais técnicas, explicando-as adequadamente
5. Discutir estratégias para superar desafios comuns neste nível
6. Propor exercícios de dificuldade média que exigem combinação de conceitos

Tópico: {topico}
Descrição: {descricao}
Nível: {nivel}

Retorne apenas o texto final.
'''
    )
    chain = prompt_template | llm | StrOutputParser()
    response = chain.invoke({'topico': topico, 'descricao': descricao, 'nivel': nivel})
    material.append(response)
    print(material)
    print(190*'-')
    print(material)
    
    return material

@app.get('/exercise_generator/{topico}/{level}/{quantidade}')
def gerar_exercicios(topico: str, level: str, quantidade: int): 
    ex = quantidade
    titulo_ex = []
    questao = []
    
    while ex != 0:
        time.sleep(1)
        print("num: ", ex)
        ex -= 1

        prompt_titulo = PromptTemplate(
        input_variables=["topico", "nivel", "quantidade","titulo_ex"],
        template='''Crie 1 exercício de alternativa de {topico} para nível {level}.
        O exercício deve:
        Ter um enunciado claro e contextualizado
        Incluir todos os dados necessários para resolução
        Terminar com uma pergunta específica
        Ser adequado ao nível {level}
        E não repita o enunciado do exercício anterior.
        {titulo_ex}
        E eu apenas quero o inunciado do exercício.

        Apresente apenas o exercício, sem numeração ou indicações de dificuldade.
        '''
        )

        chain_titulo = prompt_titulo | llm | StrOutputParser()
        titulo = chain_titulo.invoke({
            'topico': topico, 
            'level': level, 
            'quantidade': quantidade,
            'titulo_ex': titulo_ex
        })
        
        
        prompt_alternativas = PromptTemplate(
        input_variables=["titulo"],
        template='''Faça 4 alternativas para o exercício abaixo, quero que tenha apenas uma alternativa correta, e não mostre a alternativa correta.
        Apresente apenas as alternativas, sem numeração ou indicações de dificuldade.
        Quero que no começo de cada alternativa tenha a letra A), B), C) ou D).
        {titulo}
        Faça as alternativaas corespodente ao o ininciado.

        '''
        )

        chain_alternativa = prompt_alternativas | llm | StrOutputParser()
        alternativas = chain_alternativa.invoke({
            'titulo': titulo
        })
        
        split_alternativas = alternativas.split("\n")
        
        prompt_resolucao = PromptTemplate(
        input_variables=["titulo","alternativas"],
        template='''Faça a resolução do exercício abaixo e mostre a alternatica correta:
        {titulo}
        {alternativas}
        Faça a resolução de uma maneira clara e objetiva.
        '''
        )

        chain_resolucao = prompt_resolucao | llm | StrOutputParser()
        resolucao = chain_resolucao.invoke({
            'titulo': titulo,
            'alternativas': alternativas
        })
        
        prompt_correta = PromptTemplate(
        input_variables=["titulo","alternativas"],
        template='''dentre esssas alternativas eu quero que retorne apenas a alternativa correta:
        {titulo}
        {alternativas}
        Exemplo de como quero que retorne a alternativa correta:
        A) 5 figurinhas
        Preciso que a resposta seja identica a alternativa.
        '''
        )

        chain_correta = prompt_correta | llm | StrOutputParser()
        questão_correta = chain_correta.invoke({
            'titulo': titulo,
            'alternativas': alternativas
        })
        
        
        exericio = {
            'titulo': titulo,
            'alternativas': split_alternativas,
            'resolucao': resolucao,
            'correta': questão_correta
        }
        
        print(titulo)
        print(120*"=")
        print(alternativas)
        print(120*"=")
        print(resolucao)
        print(120*"-")
        print(questão_correta)
        print(120*"-")
        titulo_ex.append(titulo)
        questao.append(exericio)
    return questao

@app.get("/chat/{pergunta}")
def chat(pergunta):

    print(pergunta)
    prompt_template = PromptTemplate(
    input_variables=["pergunta"],
    template='''
você é um asistente que resopnde perguntas.
pergunta: {pergunta}
    '''
    )
    chain = prompt_template | llm | StrOutputParser()
    resposta = chain.invoke({'pergunta': pergunta})
    print(resposta)
    return resposta






class pdf_content:
    
    def extract_text(pdf):
        contents = pdf.read()
        pdf_content = PdfReader(pdf)
        text = ""
        for page_num in range(len(pdf_content.pages)):
            page = pdf_content.pages[page_num]
            text += page.extract_text() 
        return {'text': text,
                'size':len(contents),
                'pages':len(pdf_content.pages)
                }
    
def extract_pdf_text(user_id,title,chat=False):
    storage_path = f"/var/www/html/storage/app/pdfs/{user_id}/{title}.pdf" 
    with open(storage_path, "rb") as f:
        pdf_items = pdf_content.extract_text(f)
        print(pdf_items['text'])
    
    print(120*"-")
    print(f"Tamanho do arquivo: {pdf_items['size']} bytes")
    return {"size": pdf_items['size'], 
            "words": len(pdf_items['text']),
            "pages": pdf_items['pages'],
            "text": pdf_items['text']
    }


def content_pdf(text):
    prompt_content = PromptTemplate(
        input_variables=["text"],
        template='''Você é um professor experiente de mais de 15 anos em sala de aula.
        Quero que você faça um resumo detalhado do conteúdo do PDF abaixo, usando bastante markdown para deixar o texto bonito e organizado:

        {text}

        **Instruções detalhadas:**
        - **Separe o resumo por tópicos principais do PDF, usando cabeçalhos markdown (`## Título do Tópico`).**
        - **Para cada tópico, faça um parágrafo detalhado, usando listas, destaques, negritos e itálicos.**
        - **Use exemplos, citações ou destaques em bloco (`>`) quando relevante.**
        - **Inclua links fictícios ou referências internas se quiser simular uma navegação.**
        - **O texto deve ser grande, rico em detalhes e muito bem formatado, tornando a leitura agradável e visualmente interessante.**
        - **Ao final, faça um breve resumo dos pontos mais importantes.**
        '''
    )
    chain = prompt_content | llm | StrOutputParser()
    content_response = chain.invoke({'text': text})
    return content_response
     
def summary_pdf(text):
    prompt_summary = PromptTemplate(
        input_variables=["text"],
        template='''faça um resumo sobre o pdf de ate 6 palavras do conteúdo abaixo:
        {text}
        Desejo apenas um resumo de 6 palavras do conteúdo do PDF, nada mais.
        '''
    )
    chain_summary = prompt_summary | llm | StrOutputParser()
    summary_response = chain_summary.invoke({'text': text})
    return summary_response

def language_pdf(text):
    prompt_language = PromptTemplate(
        input_variables=["text"],
        template='''Analise a linguagem do texto abaixo e me informe qual é a linguagem predominante:
        {text}
        Desejo apenas a linguagem predominante do texto, nada mais.
        Ex: Português, Inglês, Espanhol, etc.
        '''
    )
    chain_language = prompt_language | llm | StrOutputParser()
    language_response = chain_language.invoke({'text': text})
    return language_response

@app.get('/new_pdf_folder/{user_id}/{title}')
async def new_pdf_folder(user_id,title):
    data_pdf = extract_pdf_text(user_id,title)
    content = content_pdf(data_pdf['text'])
    summary = summary_pdf(data_pdf['text'])
    language = language_pdf(data_pdf['text'])
    print(120*"-")
    print(content)
    print(120*"-")
    print("LINGUAGEM:",language)
    
    # Aqui você pode salvar ou processar o PDF
    return {"size": data_pdf['size'], 
            "content": content,
            "summary": summary,
            "words": len(data_pdf['text']),
            "pages": data_pdf['pages'],
            "language": language
        }


@app.get('/chat_file/{msg}/{user_id}/{title}')
async def chat_file(msg,user_id,title):
    print(msg)
    data_pdf = extract_pdf_text(user_id,title)
    char_split = CharacterTextSplitter(chunk_size=2000, chunk_overlap=500, separator=" ")
    splits = char_split.split_text(data_pdf['text'])
    
    embedding_model = HuggingFaceEmbeddings(model_name="all-MiniLM-L6-v2")
    vectorstore = InMemoryVectorStore.from_texts(texts=splits,embedding=embedding_model)
    retriever = vectorstore.as_retriever(search_type="mmr", k=10)
    
    result = retriever.invoke(msg)
    print(result)
    
    prompt = PromptTemplate(
        input_variables=["question", "context"],
        template = """Você é um assistente de IA especializado em responder perguntas sobre documentos e conteúdos técnicos.  
        Sua resposta deve ser clara, detalhada e visualmente organizada, usando Markdown para destacar títulos, tópicos e exemplos.

        **Contexto fornecido:**  
        {context}

        **Pergunta do usuário:**  
        {question}

        **Resposta (use Markdown para deixar o texto mais bonito e fácil de ler):**  
        """
    )
    chain = prompt | llm | StrOutputParser()
    response = chain.invoke({'question': msg, 'context': result})
    return response
    