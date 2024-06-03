import React, {useState} from "react";
import {Button, TextInput} from "flowbite-react";
import {Spinner} from "@material-tailwind/react";
import Requirement from "../alerts/Requirement";
import Axios from "axios";

export default function Register({setShowRegister}) {
    const [email, setEmail] = useState("");
    const [lastname, setLastname] = useState("");
    const [firstname, setFirstname] = useState("");
    const [password, setPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");
    const [loading, setLoading] = useState(false);
    const [requirements, setRequirements] = useState([]);

    const onSubmit = async () => {
        if (handleForm() == true) {
            setLoading(true);
            await Axios.post("/register", {
                    "email": email,
                    "password": password,
                    "firstname": firstname,
                    "lastname": lastname,
                },
                {
                    headers: {
                        "Content-Type": "application/json",
                    },
                }).then(() => {
                setLoading(false);
                setShowRegister(false);
            }).catch((err) => {
                setLoading(false);
                throw err;
            });
        }
    };

    const handleForm = () => {
        const validEmail = new RegExp(
            "^[a-zA-Z0-9._:$!%-]+@[a-zA-Z0-9.-]+.[a-zA-Z]$",
        );
        const validPassword = new RegExp(
            "^(?=.*?[A-Za-z])(?=.*?[0-9])(?=.*?[$&+,:;=?@#|'<>.^*()%!-]).{8,}$",
        );

        let arrayRequirements = [];

        if (password != confirmPassword) {
            arrayRequirements.push("Le mot de passe et sa confirmation ne sont pas identique");
        }
        if (!validEmail.test(email)) {
            arrayRequirements.push("Le format d'email n'est pas valide. Exemple: exemple@mail.com");
        }
        if (!validPassword.test(password)) {
            arrayRequirements.push("Le mot de passe doit comporter minimum 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial");
        }
        if (lastname == "" || firstname == "") {
            arrayRequirements.push("Le nom et le prénom ne peuvent être vide");
        }

        if (arrayRequirements.length > 0) {
            setRequirements(arrayRequirements);
            return false;
        } else {
            setRequirements([]);
            return true;
        }
    };

    return (
        <div className="space-y-6 ">
            <h3 className="text-4xl font-medium text-gray-900 dark:text-white text-center font-ChunkFive">Inscription</h3>
            {requirements.length > 0 ? (<Requirement requirements={requirements}/>) : null}
            <div className="flex">
                <TextInput className="[&>div>input]:bg-light-gray mr-3"
                           id="lastname"
                           placeholder="Nom"
                           autoFocus
                           required
                           onChange={(e) => {
                               setLastname(e.target.value);
                           }}/>
                <TextInput className="[&>div>input]:bg-light-gray ml-3"
                           id="firstname"
                           placeholder="Prénom"
                           autoFocus
                           required
                           onChange={(e) => {
                               setFirstname(e.target.value);
                           }}/>
            </div>
            <div>
                <TextInput className="[&>div>input]:bg-light-gray"
                           id="email"
                           placeholder="E-mail"
                           autoFocus
                           required
                           onChange={(e) => {
                               setEmail(e.target.value);
                           }}/>
            </div>
            <div>
                <TextInput className="[&>div>input]:bg-light-gray"
                           id="password"
                           placeholder="Créer un mot de passe"
                           type="password"
                           required
                           onChange={(e) => {
                               setPassword(e.target.value);
                           }}/>
            </div>
            <div>
                <TextInput className="[&>div>input]:bg-light-gray"
                           id="passwordVerify"
                           placeholder="Confirmer le mot de passe"
                           type="password"
                           required
                           onChange={(e) => {
                               setConfirmPassword(e.target.value);
                           }}/>
            </div>
            <div className="w-full">
                {loading ? (
                    <Spinner className="m-auto h-10 w-10 text-blue-purple"/>
                ) : (
                    <Button className="m-auto bg-blue-purple w-64 hover:opacity-75 hover:!bg-blue-purple"
                            onClick={() => onSubmit()}>Créer un compte</Button>
                )}
            </div>
            <div className="flex justify-center items-center text-sm font-medium text-gray-500 dark:text-gray-300">
                <p href="#"
                   className="text-black font-ChunkFive font-medium">
                    Vous avez déjà un compte ?
                </p>
            </div>
            <div className="w-full text-center">
                <Button className="m-auto bg-blue-purple w-40 hover:opacity-75 hover:!bg-blue-purple"
                        onClick={() => setShowRegister(false)}>Se connecter</Button>
            </div>
        </div>
    );
}
