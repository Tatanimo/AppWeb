import { Button, Checkbox, Label, Modal, TextInput } from "flowbite-react";
import React, { useRef } from "react";

export default function LoginRegisterModal({openModal, setOpenModal}) {

  return (
    <>
      <Modal className="[&>div>div]:bg-beige" dismissible show={openModal} size="md" popup onClose={() => setOpenModal(false)}>
        <Modal.Header />
        <Modal.Body>
            <div className="space-y-6 ">
              <h3 className="text-4xl font-medium text-gray-900 dark:text-white text-center font-ChunkFive">Connexion</h3>
              <div>
              <TextInput className="[&>div>input]:bg-light-gray" id="email" placeholder="E-mail" autoFocus required />
            </div>
            <div>
              <TextInput className="[&>div>input]:bg-light-gray" id="password" placeholder="Mot de passe" type="password" required />
            </div>
            <div className="w-full text-center">
              <Button className="m-auto bg-blue-purple w-64 hover:opacity-75 hover:!bg-blue-purple">Se connecter</Button>
            </div>
            <div className="flex justify-between border-b border-b-black border-solid !mt-2 pb-3 mx-8">
              <a href="#" className="text-sm text-black hover:underline dark:text-cyan-500 ml-5">
                Mot de passe oublié ?
              </a>
            </div>
            <div className="flex justify-between text-sm font-medium text-gray-500 dark:text-gray-300">
              <p href="#" className="text-black font-ChunkFive font-medium">
                Je n'ai pas encore de compte
              </p>
            </div>
            <div className="w-full text-center">
              <Button className="m-auto bg-blue-purple w-40 hover:opacity-75 hover:!bg-blue-purple">Créer un compte</Button>
            </div>
          </div>
        </Modal.Body>
      </Modal>
    </>
  );
}
