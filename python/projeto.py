import upload_image as up
import lcd
import requests, threading

LOGIN={"username":"Admin", "password":"cisco"}
urlLogin="http://127.0.0.1/projetoV2/api/auth"

# Função de login que irá proceder ao login à api e devolver a
# sessão com a autentificação 

def login():

    session=requests.Session()

    # Request de login à api
    response=session.post(urlLogin, data=LOGIN)

    if response.status_code == 200:
        print("Autentificação bem sucedida")

        return session

    print("Erro na autentificação")
    return null


print("\n******* Projeto de python iniciado *******\n\n")


session=login()

lcd.init(session)
up.init(session)

