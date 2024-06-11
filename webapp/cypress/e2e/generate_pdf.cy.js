describe('Générer un PDF', () => {
    it('test 1 - générer un PDF OK', () => {
        cy.visit('http://localhost:8001/login');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#username').type('juju.v.h.03@gmail.com');
        cy.get('#password').type('testtest');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();
        cy.visit('http://localhost:8001/pdf');

        // Entrer les informations pour générer un PDF
        cy.get('#form_title').type('Test 1');
        cy.get('#form_url').type('https://www.google.com/');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que le PDF est généré
        cy.url().should('include', 'http://localhost:8001/pdf');
        cy.contains('PDF generated successfully.').should('exist');
    });
});