import {Button, Menu, MenuHandler, MenuItem, MenuList} from "@material-tailwind/react";
import React, {useState} from "react";
import ProfessionalModal from "../modals/ProfessionalModal";
import {endpoint} from "../../../config";

function ProfileDropdown({user, professional}) {
    const [openModal, setOpenModal] = useState(false);
    const [imgIsTrue, setImgIsTrue] = useState(true);

    console.log(user);

    return (
        <>
            <Menu>
                <MenuHandler>
                    <Button className="shadow-none hover:shadow-none">
                        {imgIsTrue &&
                            <img onError={() => {
                                setImgIsTrue(false);
                            }}
                                 src={`${imgIsTrue ? `${endpoint.img}/users/user-${user.id}-1.jpg` : ``}`}
                                 className="h-8 rounded-full"/>
                        }
                        {!imgIsTrue &&
                            <div className="bg-blue-purple h-8 w-8 rounded-full flex items-center justify-center">
                                <span>
                                    {user.first_name[0]}
                                </span>
                            </div>
                        }
                    </Button>
                </MenuHandler>
                <MenuList>
                    <a href={`/profil/${user.id}`}>
                        <MenuItem>Profil</MenuItem>
                    </a>
                    {!professional ? (
                        <MenuItem onClick={setOpenModal}>Devenir professionnel</MenuItem>
                    ) : (
                        <a href={`/profil/professionnel/${professional.id}`}>
                            <MenuItem>Profil <span className="capitalize">{professional.service.type}</span></MenuItem>
                        </a>
                    )}
                    <hr className="my-2"/>
                    <a href="/logout">
                        <MenuItem>Déconnexion</MenuItem>
                    </a>
                </MenuList>
            </Menu>

            <ProfessionalModal openModal={openModal}
                               setOpenModal={setOpenModal}/>
        </>
    );
}

export default ProfileDropdown;