describe('Formulaire de Connexion', () => {
    it('test 1 - connexion OK', () => {
        cy.visit('http://localhost:8001/login');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#username').type('juju.v.h@hotmail.fr');
        cy.get('#password').type('testtest');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que l'utilisateur est connecté
        cy.url().should('include', 'http://localhost:8001/');
        cy.contains('Welcome to MyWebApp').should('exist');
    });

    it('test 2 - connexion KO', () => {
        cy.visit('http://localhost:8001/login');

        // Entrer un nom d'utilisateur et un mot de passe incorrects
        cy.get('#username').type('blop@blop.blop');
        cy.get('#password').type('blop');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que le message d'erreur est affiché
        cy.contains('Invalid credentials.').should('exist');
    });
});