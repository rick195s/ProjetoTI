import sys, requests,time



def get_api():
    return requests.get("http://127.0.0.1/projeto/api/api.php?nome=temperatura&tipo=sensor", data={"username":"Admin", "password":"cisco","valor":"1","nome":"portas","estado":"0", "tipo":"atuador"})



print("***** Ler temperatura do servidor *****")
    
try:
    while True:

        r=get_api()

        if r.status_code == 200:

            print("Valor da temperatura recebido " ,r.json())

            if int(r.json().split("º")[0]) <= 20:
                exec("./python/upload_image.py")

        else:
            print("Pedido HTTP não foi bem sucedido")
        time.sleep(2)

except KeyboardInterrupt:
    print("Programa interrompido pelo utilizador")   
    
except:
    print("Ocorreu um erro: ", sys.exc_info())
    
finally:
    print("Fim do programa")
        
