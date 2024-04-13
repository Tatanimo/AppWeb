import React, {useState} from 'react'
import { Button, TextInput } from "flowbite-react";
import { Spinner } from "@material-tailwind/react";
import Axios from "axios";

export default function Login({setShowRegister, setOpenModal}) {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [loading, setLoading] = useState(false);

    const onSubmit = async () => {
        if (email != "" && password != "") {
          setLoading(true);
          await Axios.post('/login', {
              "email": email,
              "password": password
            }, 
            {
              headers: {
                'Content-Type': 'application/json'
              }  
            }).then(() => {
              setLoading(false);
              setOpenModal(false);
            }).catch((err) => {
              setLoading(false);
              throw err;
            });
        }
    }

  return (
    <div className="space-y-6 ">
        <h3 className="text-4xl font-medium text-gray-900 dark:text-white text-center font-ChunkFive">Connexion</h3>
        <div>
            <TextInput className="[&>div>input]:bg-light-gray" id="email" placeholder="E-mail" autoFocus required onChange={(e) => {setEmail(e.target.value)}} />
        </div>
        <div>
            <TextInput className="[&>div>input]:bg-light-gray" id="password" placeholder="Mot de passe" type="password" required onChange={(e) => {setPassword(e.target.value)}} />
        </div>
        <div className="w-full">
        {loading ? (
            <Spinner className="m-auto h-10 w-10 text-blue-purple"/>
        ) : (
            <Button className="m-auto bg-blue-purple w-64 hover:opacity-75 hover:!bg-blue-purple" onClick={() => onSubmit()}>Se connecter</Button>
        )}
        </div>
        <div className="flex justify-between border-b border-b-black border-solid !mt-2 pb-3 mx-8">
            <a href="#" className="text-sm text-black hover:underline dark:text-cyan-500 ml-5">
                Mot de passe oublié ?
            </a>
        </div>
        <div className="flex justify-between text-sm font-medium text-gray-500 dark:text-gray-300">
            <p className="text-black font-ChunkFive font-medium">
                Je n'ai pas encore de compte
            </p>
        </div>
        <div className="w-full text-center">
            <Button className="m-auto bg-blue-purple w-40 hover:opacity-75 hover:!bg-blue-purple" onClick={() => setShowRegister(true)}>Créer un compte</Button>
        </div>
    </div>
  )
}
