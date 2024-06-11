describe('Formulaire d\'Inscription', () => {
    it('test 1 - inscription OK', () => {
        cy.visit('http://localhost:8001/register');

        // Entrer les informations d'inscription
        cy.get('#registration_form_firstname').type('Julie');
        cy.get('#registration_form_lastname').type('VH');
        cy.get('#registration_form_email').type('juju.v.h@gmail.com');
        cy.get('#registration_form_plainPassword').type('testtest');
        cy.get('[type="checkbox"]').check();

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que l'utilisateur est inscrit
        cy.url().should('include', 'http://localhost:8001/');
        cy.contains('Welcome to MyWebApp').should('exist');
    });
    it('test 2 - inscription KO', () => {
        cy.visit('http://localhost:8001/register');

        // Entrer les informations d'inscription
        cy.get('#registration_form_firstname').type('Julie');
        cy.get('#registration_form_lastname').type('VH');
        cy.get('#registration_form_email').type('blop@blop.blop');
        cy.get('#registration_form_plainPassword').type('blop');
        cy.get('[type="checkbox"]').check();

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que l'utilisateur est inscrit
        cy.contains('Your password should be at least 6 characters').should('exist');
    });
});