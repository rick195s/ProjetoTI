from tkinter import *

urlUpdate="http://127.0.0.1/projetoV2/api/updateDisp"


window = Tk()

def verifyLenght(msg):

    # No CPT o Lcd só mostra 14 caracteres por isso é 
    # necessario fazermos essa verificação antes de alterar
    # o valor pela api

    if len(msg) > 14:
        return None

    return msg

def updateMsg(session, msg):

    # Armazenar o valor da variavel
    msg=verifyLenght(msg.get())

    
    if msg != None:
        
        window.destroy()
        data={
            "name":"Lcd",
            "type":"sensor",
            "state": 0,
            "value": msg,
        }

        # Enviar o pedido
        session.post(urlUpdate, data)

        print("Mensagem do LCD atualizada")

    else:
        print("Mensagem demasiado grande")

def init(session):


    # Titulo da janela
    window.title("Alterar texto do LCD no CPT")

    #Dimensao da janela
    window.geometry("350x150")
    msg = StringVar()


    # Adicionar uma mensagem na janela
    Label(window, text="Max 14 caracteres").pack()

    # Input para o utilizador colocar o texto
    Entry(window, textvariable = msg).pack()

    # Botao que ira submeter
    Button(window, text = "Ok", command= lambda: updateMsg(session, msg)).pack()
    window.mainloop()