import cv2,requests,sys,time

def take_pic():
    camera = cv2.VideoCapture(0)
    ret, image = camera.read()
    print ("Resultado da Camera=" + str(ret))
    cv2.imwrite('webcam.jpg', image)
    camera.release()
    cv2.destroyAllWindows()
    

def send_file():
    url="http://127.0.0.1/projeto/upload.php"
    files={'imagem':open('webcam.jpg', 'rb')}
    r=requests.post(url, files=files)



def get_api():
    return requests.get("http://127.0.0.1/projeto/api/api.php?nome=temperatura&tipo=sensor", data={"username":"Admin", "password":"cisco","valor":"1","nome":"portas","estado":"0", "tipo":"atuador"})


print("***** Ler temperatura do servidor *****")
    
try:
    while True:

        r=get_api()

        if r.status_code == 200:

            print("Valor da temperatura recebido " ,r.json())

            if int(r.json().split("º")[0]) <= 20:
                take_pic()
                send_file()

        else:
            print("Pedido HTTP não foi bem sucedido")
        time.sleep(2)

except KeyboardInterrupt:
    print("Programa interrompido pelo utilizador")   
    
except:
    print("Ocorreu um erro: ", sys.exc_info())
    
finally:
    print("Fim do programa")
        
