Bienvenue dans le ProjetDev / Un site de réservation de covoiturage.
Ce projet a été réalisé par Michaël LOPES et Luca GARIC.

!Vagrant et VirtualBox doivent être installés à leurs emplacements par défaut!

1. Tout d’abord il faut installer Virtualbox grâce au lien ci-dessous
	https://download.virtualbox.org/virtualbox/6.0.16/VirtualBox-6.0.16-135674-Win.exe

2. Ensuite nous allons installer Vagrant grâce au lien ci-dessous
	https://releases.hashicorp.com/vagrant/2.2.7/vagrant_2.2.7_x86_64.msi

3. Il faudra aussi installer git (git bash notamment) pour exécuter les commandes d’installation :
	https://github.com/git-for-windows/git/releases/download/v2.26.0.windows.1/Git-2.26.0-64-bit.exe

4. Une fois ces logiciels installés, nous allons exécuter git bash (clic droit git-bash here), le répertoire importe peu ici. Nous allons exécuter la commande suivante:
	vagrant box add laravel/homestead
	git clone https://github.com/laravel/homestead.git ~/ProjetDev/Homestead
	git checkout release

5. Ensuite il faudra exécuter les commandes suivantes :
	cd C:/Utilisateur/nomUser/ProjetDev/Homestead
	bash init.sh
	ssh-keygen -t rsa -C "you@homestead"
	(Pour le ssh-keygen lors de la demande d’une “passphrase” saisir la touche "entrer")

6. Éditer le fichier Homestead.yaml se trouvant dans ProjetDev/Homestead.
	Maps correspond au dossier du projet physique (là où vous avez positionné notre projet (ex: C:/Utilisateur/nomUser/Desktop/ProjetDevWeb).
	To : correspond à l’emplacement du projet sur la machine virtuelle.
	map : correspond au nom de domaine.

	folders : 
		map: C:/Utilisateur/nomUser/Desktop/ProjetDevWeb
		to: /home/vagrant/ProjetDevWeb

	sites:
		map: projetdevweb.io   
		to: /home/vagrant/ProjetDevWeb/public

7. Une fois ces étapes réalisées, deux options existent :
	Soit vous allez dans votre dossier : C:/Windows/System32/drivers/etc, ici ouvrez le fichier host en administrateur avec un éditeur de texte et ajoutez-y cette ligne à la fin :
		192.168.10.10    projetdevweb.io
		Et pour accéder au site vous aurez juste à saisir projetdevweb.io/fr/ ou projetdevweb.io/en/
	Soit vous ne modifier pas le fichier System32 et pour accéder au site vous devrez saisir 192.168.10.10/fr/ ou 192.168.10.10/en/

8. Ensuite ouvrez git bash ou un invite de commande dans votre dossier Homestead et lancez ces commandes.
	vagrant up
	vagrant ssh
	cd ProjetDevWeb/ProjetDev
	composer install
	php bin/console doctrine:fixtures:load
	php bin/console server:run

9. Allez maintenant sur un navigateur web et saisir :
	projetdevweb.io/fr/ ou projetdevweb.io/en/
	ou
	192.168.10.10/fr/ ou 192.168.10.10/en/

10. Pour se connecter nous avons déjà créé 2 comptes (un utilisateur et un administrateur) :
	Pour l'utilisateur : email => user@user.fr	MDP => user
	Pour l’administrateur : email => admin@admin.fr	MDP => admin

11. Une fois le projet testé, retourner sur l’invite de commande de git que vous n’avez pas encore fermé et saisir les commandes suivantes :
	Appuyer sur ctrl + c (pour stopper le serveur)
	exit
	vagrant halt
