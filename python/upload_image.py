import sys, requests,time, cv2
urlUpload="http://127.0.0.1/projetoV2/api/uploadImage"


# Função que é responsável por tirar uma fotografia
# e guarda la

def take_pic():

    print("A tirar fotografia")


    camera = cv2.VideoCapture(0, cv2.CAP_DSHOW)
    
    # Tirar fotografia

    ret, image = camera.read()

    print("Fotografia tirada")

    # Guardar fotografia

    cv2.imwrite('webcam.jpg', image)
    camera.release()
    cv2.destroyAllWindows()
    
# Função que irá dar upload da imagem previamente guardada
# para o dashboard através da api 

def send_file(session):
    
    print("A enviar fotografia")
    
    files={'image':open('webcam.jpg', 'rb')}

    print("Fotografia enviada")

    # Post request à api com a imagem 
    response = session.post(urlUpload, files=files)

    print(response.text)


# Função que devolverá o valor da garagem
def get_garagem(session):
    return session.get("http://127.0.0.1/projetoV2/api/findDisp?name=Armazem&type=atuador")


def init(session):
    print("***** A obter estado do armazem *****\n\n")
        
    try:
        

        while True:

            # Pedido get à api para ter acesso ao estado da garagem

            request = get_garagem(session)

            # Verificar se houve algum erro ao executar o request

            if request.status_code == 200:

                print("Estado da porta do armazem recebida " , request.json())

                # green = aberta, red = fechada
                if request.json() == "green":
                    take_pic()
                    send_file(session)

            else:
                print("Pedido à api não foi bem sucedido")

            #delay de 2 segundos
            time.sleep(2)

    except KeyboardInterrupt:
        print("Programa interrompido pelo utilizador")   
        
    except:
        print("Ocorreu um erro: ", sys.exc_info())
        
    finally:
        print("Fim do programa")
            
